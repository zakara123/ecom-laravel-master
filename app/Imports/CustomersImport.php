<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{

    use Importable, SkipsErrors, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $firstname=trim(@$row['first_name']);
        $lastname =trim(@$row['last_name']);
        $company_name =trim(@$row['company_name']);
        $address1=trim(@$row['address_1']);
        $address2 =trim(@$row['address_2']);
        $city =trim(@$row['city']);
        $country =trim(@$row['country']);
        $email =trim(@$row['email']);
        $phone =trim(@$row['phone']);
        $fax =trim(@$row['fax']);
        $brn_customer =trim(@$row['brn']);
        $vat_customer =trim(@$row['vat']);
        $can_customer_company = 0;

        if($company_name != ''){
            $is_exist = Customer::where('company_name','=',$company_name)
           
            ->exists();
            $can_customer_company = 1;
        }else{
            $is_exist = Customer::where('firstname','=',$firstname)
            ->where('lastname','=',$lastname)
            ->where('email','=',$email)
            ->exists();
        }
           
            if (!$is_exist) {
                return Customer::create([
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'company_name' => $company_name,
                    'address1' => $address1,
                    'address2' => $address2,
                    'city' => $city,
                    'country' => $country,
                    'email' => $email,
                    'phone' => str_replace("'","",$phone),
                    'fax' => $fax,
                    'can_customer_company'=>$can_customer_company,
                    'brn_customer' => $brn_customer,
                    'vat_customer' => $vat_customer,
                ]);
            }
        
    }
}
