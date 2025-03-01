<?php

namespace App\Imports;

use App\Imports\Ledger;
use App\Imports\LedgerImport;
use App\Imports\JournalEntry;
use App\Imports\Supplier;
use App\Imports\Bill;
use App\Imports\Store;
use App\Imports\PayementMethodSales;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

HeadingRowFormatter::default('none');


class ImportLedgerMultiplSheet implements ToArray, WithHeadingRow, WithEvents 
{
    public $sheetNames;
    public $sheetData;

    public function __construct(){
        $this->sheetNames = [];
        $this->sheetData = [];
    }
    public function array(array $array)
    {
        $ledger_name = '';
        $ledger_name_excel = (array)explode('-',$this->sheetNames[count($this->sheetNames)-1]);
        foreach($ledger_name_excel as $lne){
            if (!is_numeric( $lne)) $ledger_name = trim($lne);
        }
      
        if (!empty($ledger_name) && $ledger_name != 'Worksheet') {
            $transactions = $array;
            $check_ledger = Ledger::where('name','=', $ledger_name)->orderBy('id','DESC')->first();
            
            if(!$check_ledger){
                $ledger = Ledger::updateOrCreate([
                    'name' => $ledger_name,
                    'id_ledger_group' => $id_ledger_group,
                ]);
                $id_ledger = $ledger->id;
            } else $id_ledger = $check_ledger->id;
            foreach($transactions as $val){
             $transaction = trim($val['Transaction']);
             $date_excel = trim($val['Date']);
             $amount_origin = trim($val['Amount']);
             $date = date('Y-m-d',strtotime(str_replace('/','-',$date_excel)));
             $journal_id = 1;
             $last_id_journal = JournalEntry::orderBy('id', 'DESC')->first();
             if ($count_journal_c > 0) $journal_id = $last_id_journal->journal_id + 1;
             
             $amount = 0;
             if (!empty(trim($amount_origin))) $amount = $amount_origin;
             if (str_contains($transaction,'Invoice ID') || str_contains($transaction,'Sales ID')){
                $id_sales = $id_ledger_recevable = 0;
                $check_ledger_rec = Ledger::where('name','=', 'Accounts Receivable')->orderBy('id','DESC')->first();
                if(!$check_ledger_rec){
                    $ledger_rec = Ledger::updateOrCreate([
                        'name' => 'Accounts Receivable',
                        'id_ledger_group' => $id_ledger_group,
                    ]);
                    $id_ledger_recevable = $ledger_rec->id;
                } else $id_ledger_recevable = $check_ledger_rec->id;


                $client_or = str_replace('Invoice ID','',str_replace('Sales ID','',$transaction));
                $customer_excel = (array)explode('-',$client_or);
                $customer_name = '';
                
                foreach($customer_excel as $ce){
                    if (!is_numeric($ce)) $customer_name = trim($ce);
                }
                
                $name = 'Sales #'.$id_sales;

                
                
                $debit = JournalEntry::create([
                    'id_order' => $id_sales,
                    'debit' => $id_ledger_recevable,
                    'credit' => null,
                    'amount' => $amount,
                    'date' => $date,
                    'name' => $name,
                    'is_pettycash' => 1,
                    'journal_id' => $journal_id,
                ]);
                
                $credit = JournalEntry::create([
                    'id_order' => $id_sales,
                    'debit' => null,
                    'credit' => $id_ledger,
                    'amount' => $amount,
                    'date' => $date,
                    'name' => $name,
                    'is_pettycash' => 1,
                    'journal_id' => $journal_id,
                ]);
             }  
             
            }
        }
       
       
    }

    public function add_bill($id_supplier,$b_amount,$b_description,$date){
        $supplier = Supplier::find($id_supplier);

        $store = Store::where('name','=','Default Store')->first();
        $payment_methode = PayementMethodSales::where('payment_method','=','Cash')->first();

        $store_name = "";
        if(isset($store->name)) $store_name = $store->name;

        $bills = new Bill([
            'amount' => $b_amount,
            'status' => "Pending",
            'bill_reference' => "#BILL_".$id_supplier."_".$date,
            'id_supplier' => $supplier->id,
            'supplier_name' => $supplier->name,
            'supplier_email' => $supplier->order_email,
            'supplier_phone' => $supplier->mobile,
            'supplier_address' => $supplier->address,
            'comment' => $b_description,
            'id_store' => $store->id,
            'store' => $store_name,
            'payment_methode' => $payment_methode->id
        ]);
        $bills->save();
        return $bills->id;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $this->sheetNames[] = $event->getSheet()->getTitle();
            }
        ];
    }
    public function chunkSize(): int
    {
        return 100;
    }


    public function getSheetNames() {
        return $this->sheetNames;
    }
}
