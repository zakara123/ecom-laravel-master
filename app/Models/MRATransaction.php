<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MRATransaction extends Model
{
    use HasFactory;

    public static function mra_ebs_transaction($sales, $newSales, $customer,$paid=false,$typeDesc='Standard',
                                        $creditnote=null,$debitnote=null,$id_mra_sales=null,$resend=false)
    {
        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();
        $ebs_transactionType = Setting::where("key", "ebs_transactionType")->first();
        $ebs_invoiceIdentifier = Setting::where("key", "ebs_invoiceIdentifier")->first();
        $ebs_invoiceTypeDesc = Setting::where("key", "ebs_invoiceTypeDesc")->first();
        $ebs_mraId = Setting::where("key", "ebs_mraId")->first();
        $ebs_areaCode = Setting::where("key", "ebs_areaCode")->first();
        $ebs_mraUsername = Setting::where("key", "ebs_mraUsername")->first();
        $ebs_mraPassword = Setting::where("key", "ebs_mraPassword")->first();
        $ebs_token_url = Setting::where("key", "ebs_token_url")->first();
        $ebs_transmit_url = Setting::where("key", "ebs_transmit_url")->first();


        $ebsMraId = @$ebs_mraId->value;
        $ebsMraUsername = @$ebs_mraUsername->value;
        $ebsMraPassword = @$ebs_mraPassword->value;
        $areaCode = @$ebs_areaCode->value;

        $publicKey = "";
        // Generate a random AES key
        $aesKey = openssl_random_pseudo_bytes(32); // 32 bytes for AES-256

        // Convert the AES key to Base64 string
        $aesKeyBase64 = base64_encode($aesKey);

        //echo 'AES KEY = ' .$aesKeyBase64. "<br>";
        $payload = array(
            'encryptKey' => $aesKeyBase64,
            'username' => $ebsMraUsername,
            'password' => $ebsMraPassword,
            'refreshToken' => true
        );

        // Import the certificate
        $certPath = base_path().'/public/PublicKey.crt';
        $certContent = file_get_contents($certPath);
        $cert = openssl_x509_read($certContent);

        // Extract the public key from the certificate
        // Encrypt payload using MRA public key
        $pubKeyDetails = openssl_pkey_get_details(openssl_pkey_get_public($cert));
        $publicKey = $pubKeyDetails['key'];
        $encryptedData = '';
        openssl_public_encrypt(json_encode($payload), $encryptedData, $publicKey);

        // Encode encrypted data to Base64
        $base64EncodedData = base64_encode($encryptedData);

        $requestId = 1;
        if (!$resend){
            $invoiceCounter = new SalesInvoiceCounter();
            $invoiceCounter->sales_id = $sales->id;
            if ($debitnote) {
                $invoiceCounter->debitnote_id = $debitnote;
                $invoiceCounter->is_debitnote = 'yes';
            }
            elseif ($creditnote) {
                $invoiceCounter->creditnote_id = $creditnote;
                $invoiceCounter->is_creditnote = 'yes';
            } else {
                $invoiceCounter->is_sales = 'yes';
            }
            $invoiceCounter->save();
        }

        $ebs_invoiceCounter = SalesInvoiceCounter::max('id');

        if ($resend){
            if ($debitnote) {
                $ebs_invoiceCounter = SalesInvoiceCounter::where('sales_id',$sales->id)
                    ->where('debitnote_id',$debitnote)
                    ->first();
                $ebs_invoiceCounter = $ebs_invoiceCounter->id;
            }
            elseif ($creditnote) {
                $ebs_invoiceCounter = SalesInvoiceCounter::where('sales_id',$sales->id)
                    ->where('creditnote_id',$creditnote)
                    ->first();
                $ebs_invoiceCounter = $ebs_invoiceCounter->id;
            } else {
                $ebs_invoiceCounter = SalesInvoiceCounter::where('sales_id',$sales->id)
                    ->where('is_sales','yes')
                    ->first();
                $ebs_invoiceCounter = $ebs_invoiceCounter->id;
            }
        }

        if ($ebs_invoiceCounter){
            $requestId = $ebs_invoiceCounter;
        }

        $postData = array(
            'requestId' => $requestId,
            'payload' => $base64EncodedData
        );
        $requestHeadersAuth = [
            'accept: application/json',
            'Content-Type: application/json',
            'ebsMraId: ' . $ebsMraId,
            'username: ' . $ebsMraUsername
        ];

        //echo '<br><br>Data to: ' . json_encode($postData) . "<br>";

        $token_url = $ebs_token_url->value;
        $transmit_url = $ebs_transmit_url->value;

        $chAuth = curl_init();
        curl_setopt($chAuth, CURLOPT_URL, $token_url);
        curl_setopt($chAuth, CURLOPT_POST, 1);
        curl_setopt($chAuth, CURLOPT_POSTFIELDS, json_encode($postData)); //Post Fields
        curl_setopt($chAuth, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chAuth, CURLOPT_HTTPHEADER, $requestHeadersAuth);
        curl_setopt($chAuth, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chAuth, CURLOPT_SSL_VERIFYPEER, 0);
        $responseDataAuth = curl_exec($chAuth);

        //echo "<br> responseDataAuth: = " . $responseDataAuth;
        //Decode the JSON response into a PHP associative array
        $responseArray = json_decode($responseDataAuth, true);

        //MRA key received from generate token

        if(!isset($responseArray['token']) || !$responseArray['token']){
            if ($debitnote){
                $salesEbsResult = DebitNoteSales::find($debitnote);
                $salesEbsResult->update(
                    [
                        'invoiceIdentifier' => $ebs_invoiceIdentifier->value.$requestId,
                        'responseId' => $ebs_invoiceIdentifier->value.$requestId,
                        'requestId' => $requestId,
                        'status' => 'Down',
                        'errorMessages' =>  'Error in Url Generate token'
                    ]
                );
                return true;
            }elseif ($creditnote){
                $salesEbsResult = CreditNote::find($creditnote);
                $salesEbsResult->update(
                    [
                        'responseId' => $ebs_invoiceIdentifier->value.$requestId,
                        'invoiceIdentifier' => $ebs_invoiceIdentifier->value.$requestId,
                        'requestId' => $requestId,
                        'status' => 'Down',
                        'errorMessages' =>  'Error in Url Generate token'
                    ]
                );
                return true;
            } else {
                if ($resend && (int)$id_mra_sales) {
                    $salesEbsResult = SalesEBSResults::find($id_mra_sales);
                    $salesEbsResult->update(
                        [
                            'invoiceIdentifier' => $ebs_invoiceIdentifier->value.$requestId,
                            'responseId' => $ebs_invoiceIdentifier->value.$requestId,
                            'requestId' => $requestId,
                            'status' => 'Down',
                            'errorMessages' =>  'Error in Url Generate token'
                        ]
                    );
                }else {
                    $salesEbsResult = SalesEBSResults::where('sale_id',$sales->id)->first();
                    $salesEbsResult->update(
                        [
                            'invoiceIdentifier' => $ebs_invoiceIdentifier->value.$requestId,
                            'responseId' => $ebs_invoiceIdentifier->value.$requestId,
                            'requestId' => $requestId,
                            'status' => 'Down',
                            'errorMessages' =>  'Error in Url Generate token'
                        ]
                    );
                }

                return true;
            }
        }

        $token = $responseArray['token'];

        $mraKey = $responseArray['key'];

        $company = Company::latest()->first();
        $buyer_name = '';
        if (!empty($customer->company_name)) {
            $buyer_name = $customer->company_name;
        } else {
            $firstname = $customer->firstname;
            $lastname = $customer->lastname;
            $buyer_name = $firstname . ' '. $lastname;
        }


        $data = [];

        foreach ($newSales as $item) {
            /// get stock line stock id
            if ($item->discount != NULL) $item->discount = 0;

            $taxCode = 'TC05';
            $vatAmt = 0;
            $amtWoVatCur = $item->order_price;

            if ($item->tax_sale == 'VAT Exempt'){
                $taxCode = 'TC03';
            }
            elseif ($item->tax_sale == '15% VAT'){
                $taxCode = 'TC01';
                $amtWoVatCur = $item->order_price - (($item->order_price* (15/100)));
                $vatAmt = $item->order_price - $amtWoVatCur;
            }
            elseif ($item->tax_sale == 'Zero Rated'){
                $taxCode = 'TC02';
            }


            $data[] = [
                'itemNo' =>  $item->product_id,
                'taxCode' => $taxCode,
                'nature' => 'GOODS',
                'productCodeMra' => '',
                'productCodeOwn' => $item->product_name,
                'itemDesc' => $item->product_name,
                'quantity' => (int)$item->quantity, // Convertir en entier si nécessaire
                'unitPrice' => number_format((float)$item->order_price, 2, '.', ''),
                'discount' => number_format((float)$item->discount, 2, '.', '') ,
                'amtWoVatCur' => number_format((float)$amtWoVatCur, 2, '.', ''),
                'vatAmt' => number_format((float)$vatAmt, 2, '.', ''),
                'totalPrice' => number_format((float)$item->order_price * $item->quantity, 2, '.', '')
            ];

        }


        $sales_transaction = "CASH";
        $payment_slug = PayementMethodSales::find($sales->payment_methode);
        if($payment_slug->payment_method =='Debit/Credit Card') {
            $sales_transaction = "CARD";
        }
        elseif($payment_slug->payment_method =='Credit Sale' || $payment_slug->payment_method =='Credit Note') {
            $sales_transaction = "CREDIT";
        }
        elseif(str_contains($payment_slug->payment_method, 'Cheque')) {
            $sales_transaction = "CHEQUE";
        }
        elseif(str_contains($payment_slug->payment_method, 'Bank Transfer')) {
            $sales_transaction = "BNKTRANSFER";
        }
        elseif(str_contains($payment_slug->payment_method, 'Cash')) {
            $sales_transaction = "CASH";
        }
        else {
            $sales_transaction = "OTHER";
        }

        $total_paid = 0;
        if($sales->status == 'Paid'){
            $total_paid = $sales->amount;
        }
        $ebs_typeOfPersonDesc = 'STD';
        if($typeDesc == 'Credit Note'){
            $ebs_typeOfPersonDesc = 'CRN';
        } elseif ($typeDesc == 'Debit Note'){
            $ebs_typeOfPersonDesc = 'DRN';
        }


        if($sales->status == 'Draft') $ebs_typeOfPersonDesc = 'PRF';


        $ebs_trainingmode = Setting::where("key", "ebs_trainingmode")->first();
        if ($ebs_trainingmode->value == 'On') {
            $ebs_typeOfPersonDesc = 'TRN';
        }

        $ebs_sales_date = date('Ymd H:i:s', strtotime(str_replace('/', '-', $sales->created_at)));

        $reason = "Return of product";
        if ($creditnote){
            $cn = CreditNote::find($creditnote);
            $reason = $cn->reason;
        }
        if ($debitnote){
            $dn = DebitNoteSales::find($debitnote);
            $reason = $dn->reason;
        }

        $b_tan = '';
        if($customer->vat_customer) $b_tan = $customer->vat_customer;
        $b_brn = '';
        if($customer->brn_customer) $b_brn = $customer->brn_customer;
        $b_adr = '';
        if($customer->address1) $b_adr = $customer->address1;

        $arInvoice = [
            'invoiceCounter' => $requestId,
            'transactionType' => $ebs_transactionType->value,
            'personType' => $ebs_typeOfPerson->value,
            'invoiceTypeDesc' => $ebs_typeOfPersonDesc,
            'currency' => $sales->currency,
            'invoiceIdentifier' => $ebs_invoiceIdentifier->value.$requestId,
            'invoiceRefIdentifier' => $ebs_invoiceIdentifier->value.$requestId,
            'previousNoteHash' => 'prevNote',
            'reasonStated' => $reason,
            'totalVatAmount' => number_format((float)$sales->tax_amount, 2, '.', ''),
            'totalAmtWoVatCur' => number_format((float)$sales->subtotal, 2, '.', ''),
            'invoiceTotal' => number_format((float)$sales->amount, 2, '.', ''),
            'totalAmtPaid' => number_format((float)$total_paid, 2, '.', ''),
            'dateTimeInvoiceIssued' => $ebs_sales_date,
            "salesTransactions" => $sales_transaction,
            'seller' => [
                'name' => $company->company_name,
                'tradeName' => $company->company_name,
                'tan' => $company->tan,
                'brn' => $company->brn_number,
                'businessAddr' => $company->company_address,
                'businessPhoneNo' => $company->company_phone,
            ],
            'buyer' => [
                'name' => $buyer_name,
                'tan' => $b_tan,
                'brn' => $b_brn,
                'businessAddr' => $b_adr,
            ],
            'itemList' => $data,
        ];

        $invoiceArray = array($arInvoice);

        $jsonencode = json_encode($invoiceArray);


        //algorithm should be AES-256-ECB
        $decryptedKey = openssl_decrypt($mraKey, 'AES-256-ECB', base64_decode($aesKeyBase64));

        // algorithm should be AES-256-ECB
        $encryptedInvoice = openssl_encrypt($jsonencode, 'AES-256-ECB', base64_decode($decryptedKey), OPENSSL_RAW_DATA);

        // encrypted invoice should be encoded
        $payloadInv = base64_encode($encryptedInvoice);

        $requestHeadersInv = [
            'Content-Type: application/json',
            'ebsMraId: ' . $ebsMraId,
            'username: ' . $ebsMraUsername,
            'areaCode: ' . $areaCode,
            'token: ' . $token
        ];
        $postDataInv = [
            'requestId' => $requestId,
            'requestDateTime' => date('Ymd H:i:s'),
            'signedHash' => '',
            'encryptedInvoice' => $payloadInv
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $transmit_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postDataInv)); //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeadersInv);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $responseData = curl_exec($ch);
        $responseFinalArray = json_decode($responseData, true);

        if((isset($responseFinalArray['status']) && $responseFinalArray['status'] == 404) ||
            isset($responseFinalArray['error']) && $responseFinalArray['error'] == 'Not Found' ||
            isset($responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description']) &&
            str_contains('url', $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'])
        ){
            if ($debitnote){
                $salesEbsResult = DebitNoteSales::find($debitnote);
                $salesEbsResult->update(
                    [
                        'responseId' => $ebs_invoiceIdentifier->value.$requestId,
                        'invoiceIdentifier' => $ebs_invoiceIdentifier->value.$requestId,
                        'requestId' => $requestId,
                        'status' => 'Down',
                        'jsonRequest' => $jsonencode,
                        'errorMessages' =>  'Error in URL Transmit API',

                    ]
                );
                return true;
            }elseif ($creditnote){
                $salesEbsResult = CreditNote::find($creditnote);
                $salesEbsResult->update(
                    [
                        'invoiceIdentifier' => $ebs_invoiceIdentifier->value.$requestId,
                        'responseId' => $ebs_invoiceIdentifier->value.$requestId,
                        'requestId' => $requestId,
                        'status' => 'Down',
                        'jsonRequest' => $jsonencode,
                        'errorMessages' =>  'Error in Url Generate token'
                    ]
                );
                return true;
            } else {
                if ($resend && (int)$id_mra_sales) {
                    $salesEbsResult = SalesEBSResults::find($id_mra_sales);
                    $salesEbsResult->update(
                        [
                            'invoiceIdentifier' => $ebs_invoiceIdentifier->value.$requestId,
                            'responseId' => $ebs_invoiceIdentifier->value.$requestId,
                            'requestId' => $requestId,
                            'status' => 'Down',
                            'jsonRequest' => $jsonencode,
                            'errorMessages' =>  'Error in Url Generate token'
                        ]
                    );
                }else {
                    $salesEbsResult = SalesEBSResults::where('sale_id',$sales->id)->first();
                    $salesEbsResult->update(
                        [
                            'invoiceIdentifier' => $ebs_invoiceIdentifier->value.$requestId,
                            'responseId' => $ebs_invoiceIdentifier->value.$requestId,
                            'requestId' => $requestId,
                            'status' => 'Down',
                            'jsonRequest' => $jsonencode,
                            'errorMessages' =>  'Error in Url Generate token'
                        ]
                    );
                }
                return true;
            }
        }

        //MRA key received from generate token
        $responseId = $responseFinalArray['responseId'];
        $requestId = $responseFinalArray['requestId'];
        $status = $responseFinalArray['status'];
        $infoMessages = $responseFinalArray['infoMessages'];
        $errorMessages = $responseFinalArray['errorMessages'];
        $id_sales = $sales->id;
        $qrCode = $irn = $invoiceIdentifier = null;

        if ($creditnote){
            $salesEbsResult = CreditNote::find($creditnote);
            if(isset($responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'])) $invoiceIdentifier = $responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'];
            if(isset($responseFinalArray['fiscalisedInvoices'][0]['irn'])) $irn = $responseFinalArray['fiscalisedInvoices'][0]['irn'];
            if(isset($responseFinalArray['fiscalisedInvoices'][0]['qrCode'])) $qrCode = $responseFinalArray['fiscalisedInvoices'][0]['qrCode'];
            if(isset($responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'])) $errorMessages = $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['code'].' ==> '.$responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'];

            if(isset($infoMessages[0]['description']) && $infoMessages[0]['description']) $infoMessages = $infoMessages[0]['code'].' ==> '.$infoMessages[0]['description'];
            if(isset($errorMessages[0]['description']) && $errorMessages[0]['description']) $errorMessages = $errorMessages[0]['code'].' ==> '.$errorMessages[0]['description'];

            $salesEbsResult->update(
                [
                    'responseId' => $responseId,
                    'requestId' => $requestId,
                    'status' => $status,
                    'jsonRequest' => $jsonencode,
                    'invoiceIdentifier' => $invoiceIdentifier,
                    'irn' => $irn,
                    'qrCode' => $qrCode,
                    'infoMessages' => $infoMessages,
                    'errorMessages' => $errorMessages
                ]
            );
        }
        elseif ($debitnote){
            $salesEbsResult = DebitNoteSales::find($debitnote);
            if(isset($responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'])) $invoiceIdentifier = $responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'];
            if(isset($responseFinalArray['fiscalisedInvoices'][0]['irn'])) $irn = $responseFinalArray['fiscalisedInvoices'][0]['irn'];
            if(isset($responseFinalArray['fiscalisedInvoices'][0]['qrCode'])) $qrCode = $responseFinalArray['fiscalisedInvoices'][0]['qrCode'];
            if(isset($responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'])) $errorMessages = $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['code'].' ==> '.$responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'];

            if(isset($infoMessages[0]['description']) && $infoMessages[0]['description']) $infoMessages = $infoMessages[0]['code'].' ==> '.$infoMessages[0]['description'];
            if(isset($errorMessages[0]['description']) && $errorMessages[0]['description']) $errorMessages = $errorMessages[0]['code'].' ==> '.$errorMessages[0]['description'];

            $salesEbsResult->update(
                [
                    'responseId' => $responseId,
                    'requestId' => $requestId,
                    'status' => $status,
                    'jsonRequest' => $jsonencode,
                    'invoiceIdentifier' => $invoiceIdentifier,
                    'irn' => $irn,
                    'qrCode' => $qrCode,
                    'infoMessages' => $infoMessages,
                    'errorMessages' => $errorMessages
                ]
            );
        }
        else {
            if ($resend){
                $errorMessages = $invoiceIdentifier = "";
                if(isset($responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'])) $errorMessages = $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['code'].' ==> '.$responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'];
                if(isset($responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'])) $invoiceIdentifier = $responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'];

                if ((int)$id_mra_sales) {
                    $salesEbsResult = SalesEBSResults::find($id_mra_sales);
                    $salesEbsResult->update(
                        [
                            'responseId' => $responseId,
                            'invoiceIdentifier' => $invoiceIdentifier,
                            'requestId' => $requestId,
                            'status' => $status,
                            'jsonRequest' => $jsonencode,
                            'errorMessages' =>  $errorMessages
                        ]
                    );
                }else {
                    $salesEbsResult = SalesEBSResults::where('sale_id',$sales->id)->first();
                    $salesEbsResult->update(
                        [
                            'responseId' => $responseId,
                            'invoiceIdentifier' => $invoiceIdentifier,
                            'requestId' => $requestId,
                            'status' => $status,
                            'jsonRequest' => $jsonencode,
                            'errorMessages' =>  $errorMessages
                        ]
                    );
                }
            } else {
                $salesEbsResult = new SalesEBSResults();
                $salesEbsResult->sale_id = $id_sales;
                $salesEbsResult->responseId = $responseId;
                $salesEbsResult->requestId = $requestId;
                $salesEbsResult->status = $status;
                $salesEbsResult->jsonRequest = $jsonencode;
                if(isset($responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'])) $salesEbsResult->invoiceIdentifier = $responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'];
                if(isset($responseFinalArray['fiscalisedInvoices'][0]['irn'])) $salesEbsResult->irn = $responseFinalArray['fiscalisedInvoices'][0]['irn'];
                if(isset($responseFinalArray['fiscalisedInvoices'][0]['qrCode'])) $salesEbsResult->qrCode = $responseFinalArray['fiscalisedInvoices'][0]['qrCode'];
                if(isset($responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'])) $salesEbsResult->errorMessages = $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['code'].' ==> '.$responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'];
                if(isset($infoMessages[0]['description']) && $infoMessages[0]['description']) $salesEbsResult->infoMessages = $infoMessages[0]['code'].' ==> '.$infoMessages[0]['description'];
                if(isset($errorMessages[0]['description']) && $errorMessages[0]['description']) $salesEbsResult->errorMessages = $errorMessages[0]['code'].' ==> '.$errorMessages[0]['description'];

                $salesEbsResult->save();
            }

        }
        return $responseFinalArray;
    }
}
