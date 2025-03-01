<?php

namespace App\Http\Controllers;

use App\Models\BankInformation;
use App\Models\Cart;
use App\Models\Company;
use App\Models\Customer;
use App\Models\HeaderMenu;
use App\Models\HeaderMenuColor;
use App\Models\PayementMethodSales;
use App\Models\Sales;
use App\Models\Sales_products;
use App\Models\Setting;
use App\Models\Store;
use App\Models\User;
use App\Services\CheckoutService;
use App\Services\SalesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function checkoutFront(Request $request)
    {
        $data = $request->all();
        $session_id = Session::get('session_id');

        if (empty($session_id) || !Cart::where("session_id", $session_id)->exists()) {
            return redirect()->back()->with('error_message', 'Cart is empty! Please select products')->withInput();
        }

        $pickup_or_delivery = $data['pickup_or_delivery'] ?? null;

        if ($pickup_or_delivery === "Pickup") {
            if (empty($data['store_pickup']) || empty($data['pickup_date'])) {
                return redirect()->back()->with('error_message', 'Pickup Store or Date is empty.')->withInput();
            }
        } elseif ($pickup_or_delivery === "Delivery") {
            if (empty($data['delivery_method'])) {
                return redirect()->back()->with('error_message', 'Delivery Method is empty.')->withInput();
            }
        }

        $customer = Customer::firstWhere("email", $data['email']);

        if (!$customer) {
            $this->validate($request, [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'email|unique:customers',
            ]);

            $customer = Customer::updateOrCreate([
                'email' => $data['email'],
            ], [
                'name' => $data['firstname'] . ' ' . $data['lastname'],
                'company_name' => $data['firstname'] . ' ' . $data['lastname'],
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'address1' => $data['address1'],
                'address2' => $data['address2'],
                'phone' => $data['phone'],
                'city' => $data['city'],
                'country' => $data['country'],
            ]);

            if (!User::firstWhere("email", $data['email'])) {
                User::updateOrCreate([
                    'email' => $data['email'],
                ], [
                    'name' => $data['firstname'] . ' ' . $data['lastname'],
                    'phone' => $data['phone'],
                    'login' => $data['email'],
                    'role' => 'customer',
                    'password' => Hash::make('123456789'),
                ]);
            }
        }

        $sales = SalesService::createSales($data, $customer);

        CheckoutService::createJournalEntry($sales);
        CheckoutService::generatePdfDocuments($sales->id);
//        CheckoutService::processStockApi($sales, $session_id, $data['id_store']);

        $paymentMethode = PayementMethodSales::find($sales->payment_methode);
        $onlineshop_order_mail = Setting::whereIn('key', ['send_onlineshop_order_mail', 'send_onlineshop_order_mail_admin'])->pluck('key', 'value')->all();

        if (in_array('yes', $onlineshop_order_mail)) {
            if ($paymentMethode && $paymentMethode->payment_method !== 'Debit/Credit Card') {
                $this->send_email($sales->id, "");
            }
        }

        CheckoutService::emptyCart();

        if ($paymentMethode && $paymentMethode->payment_method === 'Debit/Credit Card') {
            return CheckoutService::mcb_payement_view($sales->id);
        }

        return CheckoutService::thankyou($sales->id);
    }

}
