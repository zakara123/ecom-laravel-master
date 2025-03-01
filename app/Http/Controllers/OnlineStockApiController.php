<?php

namespace App\Http\Controllers;

use App\Models\OnlineStockApi;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Products;

class OnlineStockApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if ($request->has('test')) {
            $this->validate($request, [
                'api_url' => 'required',
                'username' => 'required',
                'password' => 'required',
                'barcode' => 'required'
            ]);

            $product = [];
            $online_stock_api = OnlineStockApi::latest()->first();
            $login = $request->username;
            $password = $request->password;
            $url = $request->api_url . $request->barcode;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
            $result = curl_exec($ch);
            curl_close($ch);
            $stock = json_decode($result);
            if (isset($stock->upc)) {
                $stock_line = Stock::where('barcode_value', $stock->upc)->latest()->first();
                $product = Products::find($stock_line->products_id);
            }
            $product_stock_from_api = Setting::where("key", "product_stock_from_api")->first();
            $stock_required_online_shop = Setting::where("key", "stock_required_online_shop")->first();

            return view('stock.online', compact(['online_stock_api', 'stock', 'product', 'product_stock_from_api', 'stock_required_online_shop']));
        } else {
            if (isset($request->id) && !empty($request->id)) {
                $this->validate($request, [
                    'api_url' => 'required',
                    'username' => 'required',
                    'password' => 'required'
                ]);
                $settings = OnlineStockApi::find($request->id);
                $settings->update([
                    'api_url' => $request->api_url,
                    'username' => $request->username,
                    'password' => $request->password
                ]);
            } else {
                $this->validate($request, [
                    'api_url' => 'required',
                    'username' => 'required',
                    'password' => 'required'
                ]);
                OnlineStockApi::updateOrCreate([
                    'api_url' => $request->api_url,
                    'username' => $request->username,
                    'password' => $request->password
                ]);
            }

            return redirect()->back()->with('success', 'Settings Saved Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function get_stock_api()
    {
        /* $client = new Client();
        $response = $client->get('https://my.posterita.com/function?name=stock-info&domain=BataRetail&upc=091168240209', [
            'auth' => [
                'fitinshoe',
                'FunkyB@t@'
            ]
        ]); */
        /* $response = Http::withBasicAuth('fitinshoe', 'FunkyB@t@')->get('https://my.posterita.com/function?name=stock-info&domain=BataRetail&upc=091168240209');

        var_dump($response);die; */
        $login = 'fitinshoe';
        $password = 'FunkyB@t@';
        $url = 'https://my.posterita.com/function?name=stock-info&domain=BataRetail&upc=091168240209';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $result = curl_exec($ch);
        curl_close($ch);
        echo json_encode($result);
        die;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
