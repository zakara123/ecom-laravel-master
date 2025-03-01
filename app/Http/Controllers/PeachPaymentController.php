<?php

namespace App\Http\Controllers;

use App\Models\PayementMethodSales;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PeachPaymentController extends Controller
{
    // Define environment variables outside the function
    private $entityId;
    private $clientId;
    private $clientSecret;
    private $merchantId;
    private $authenticationEndpoint;
    private $checkoutEndpoint;

    public function __construct()
    {
        $credentials = json_decode(PayementMethodSales::where('payment_method', 'Peach Payment')->value('credentials'), true) ?? [];
        $this->entityId = $credentials['entityId'] ?? '8ac7a4c89309bab101930b3225f40242';
        $this->clientId = $credentials['clientId'] ?? '1343cf6864fd7a1f6e21dbb6a46d2c';
        $this->clientSecret = $credentials['clientSecret'] ?? 'yo9D+SjLZB5Jhs+HoduRNRpdONCYyJGqhSSRMceCcB10JQ58tFVPr/LtiWgL4FRG9v/dgAxefUsKWVNnk1VKhg==';
        $this->merchantId = $credentials['merchantId'] ?? '4d0de6d8c3e544e6b2297cf44d470c22';
        $this->authenticationEndpoint = $credentials['authenticationEndpoint'] ?? 'https://sandbox-dashboard.peachpayments.com/api/oauth/token';
        $this->checkoutEndpoint = $credentials['checkoutEndpoint'] ?? 'https://testsecure.peachpayments.com';
    }
    //
    public function returnPeachPayment(Request $request, $id)
    {
        if ($request['result_code'] == '000.000.000' || $request['result_code']  == '000.100.110') {
            return redirect()->route('save-mcb-payment', $id);
        } else {
            return redirect('cart')->with('error', 'Something went wrong');
        }
    }

    public function processPayment(Request $request)
    {
        $amount = $request->input('amount', 100);
        $currency = $request->input('currency', 'ZAR');
        $shopperResultUrl = $request->input('shopperResultUrl', url("return-peach-payment"));
        $merchantTransactionId = $request->input('merchantTransactionId', 'INV-0000001');
        $nonce = $request->input('nonce', (string) rand(100000, 999999));

        // Step 1: Get access token
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return response()->json(['error' => 'Failed to retrieve access token'], 500);
        }

        // Step 2: Get checkout ID
        $checkoutRequest = new Request([
            'accessToken' => $accessToken,
            'amount' => (float)$amount,
            'currency' => $currency,
            'shopperResultUrl' => $shopperResultUrl,
            'merchantTransactionId' => $merchantTransactionId,
            'nonce' => $nonce,
        ]);

        $checkoutId = $this->getCheckoutId($checkoutRequest);

        if (!$checkoutId) {
            return response()->json(['error' => 'Failed to retrieve checkout ID'], 500);
        }

        return response()->json(['checkoutId' => $checkoutId, 'key' => $this->entityId]);
    }

    private function getAccessToken()
    {
        $client = new Client();

        try {
            $response = $client->request('POST', $this->authenticationEndpoint, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'clientId' => $this->clientId,
                    'clientSecret' => $this->clientSecret,
                    'merchantId' => $this->merchantId
                ]
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode !== 200) {
                throw new \Exception("HTTP request failed with status code $statusCode");
            }

            $data = json_decode($response->getBody(), true);
            return $data['access_token'];
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getCheckoutId(Request $request)
    {
        $client = new Client();


        try {
            $request = [
                'headers' => [
                    'Origin' => url("peach-payment.php"),
                    'Referer' => url("peach-payment.php"),
                    'Authorization' => 'Bearer ' . $request->accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'authentication' => [
                        'entityId' => $this->entityId,
                    ],
                    'amount' => $request->amount,
                    'currency' => $request->currency,
                    'shopperResultUrl' => $request->shopperResultUrl,
                    'merchantTransactionId' => $request->merchantTransactionId,
                    'nonce' => $request->nonce,
                ],
            ];

            // Send POST request to the checkout endpoint
            $response = $client->request('POST', $this->checkoutEndpoint . '/v2/checkout', $request);

            // Decode and return the checkout ID
            $data = json_decode($response->getBody(), true);

            if (!isset($data['checkoutId'])) {
                throw new \Exception('Checkout ID not found in response: ' . json_encode($data));
            }

            return $data['checkoutId'];
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Capture and handle 4xx errors
            $errorResponse = $e->getResponse();
            $errorBody = $errorResponse ? json_decode($errorResponse->getBody(), true) : 'No response body';

            return [
                'error' => 'Invalid request to Peach Payments API',
                'details' => $errorBody,
            ];
        } catch (\Exception $e) {

            return [
                'error' => 'Unexpected error occurred',
                'details' => $e->getMessage(),
            ];
        }
    }
}
