<?php

namespace App\Http\Controllers;

use App\Models\PayementMethodSales;
use Illuminate\Http\Request;

class PayementMethodSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentMethods = PayementMethodSales::latest()->orderBy('id', 'DESC')->paginate(10);
        return view('settings.index', compact('paymentMethods '));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paymentMethod.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'payment_method' => 'required',

        ]);


        $slug = self::transform_slug($request->payment_method);

        $is_default = 'no';

        if (request()->has('is_default') === false) $is_default = 'no';
        else $is_default = 'yes';

        $is_on_bo_sales_order = 'yes';

        if (request()->has('is_on_bo_sales_order') === false) $is_on_bo_sales_order = 'no';
        else $is_on_bo_sales_order = 'yes';

        $is_on_online_shop_order = 'yes';

        if (request()->has('is_on_online_shop_order') === false) $is_on_online_shop_order = 'no';
        else $is_on_online_shop_order = 'yes';

        PayementMethodSales::updateOrCreate([
            'slug' => $slug,
            'payment_method' => $request->payment_method,
            'text_email' => $request->text_email,
            'text_email_before' => $request->text_email_before,
            'text_email_before_invoice' => $request->text_email_before_invoice,
            'text_email_after_invoice' => $request->text_email_after_invoice,
            'text_pdf_before' => $request->text_pdf_before,
            'text_pdf_after' => $request->text_pdf_after,
            'text_pdf_before_invoice' => $request->text_pdf_before_invoice,
            'text_pdf_after_invoice' => $request->text_pdf_after_invoice,
            'thankyou' => $request->thankyou,
            'failed' => $request->failed,
            'is_default' => $is_default,
            'is_on_bo_sales_order' => $is_on_bo_sales_order,
            'is_on_online_shop_order' => $is_on_online_shop_order

        ]);

        return redirect()->route('settings.index')->with('message', 'Payement Method Created Successfully');
    }

    protected function transform_slug($str)
    {
        $str = preg_replace('~[^\pL\d]+~u', '-', $str);
        $str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
        $str = preg_replace('~[^-\w]+~', '', $str);
        $str = trim($str, '-');
        $str = preg_replace('~-+~', '-', $str);
        $str = strtolower($str);
        return $str;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\payementMethodSales  $payementMethodSales
     * @return \Illuminate\Http\Response
     */
    public function show(payementMethodSales $payementMethodSales)
    {
        return view('paymentMethod.show', compact('payementMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\payementMethodSales  $payementMethodSales
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paymentMethode = PayementMethodSales::find($id);

        return view('paymentMethod.edit', compact('paymentMethode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\payementMethodSales  $payementMethodSales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'payment_method' => 'required',
        ]);


        $payementMethode = PayementMethodSales::find($id);

        $slug = self::transform_slug($request->payment_method);

        $payementMethode->update([
            'slug' => $slug,
            'payment_method' => $request->payment_method,
            'text_email' => $request->text_email,
            'text_email_before' => $request->text_email_before,
            'text_email_before_invoice' => $request->text_email_before_invoice,
            'text_email_after_invoice' => $request->text_email_after_invoice,
            'text_pdf_before' => $request->text_pdf_before,
            'text_pdf_after' => $request->text_pdf_after,
            'text_pdf_before_invoice' => $request->text_pdf_before_invoice,
            'text_pdf_after_invoice' => $request->text_pdf_after_invoice,
            'thankyou' => $request->thankyou,
            'failed' => $request->failed,
        ]);
        return redirect()->route('settings.index')->with('message', 'Payement Method updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\payementMethodSales  $payementMethodSales
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payementMethode = PayementMethodSales::find($id);
        $payementMethode->delete();
        return redirect()->route('settings.index')->with('message', 'Payement Method Deleted Successfully');
    }
}
