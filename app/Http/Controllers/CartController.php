<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Company;
use App\Models\Delivery;
use App\Models\HeaderMenu;
use App\Models\HeaderMenuColor;
use App\Models\PayementMethodSales;
use App\Models\Product_image;
use App\Models\ProductVariation;
use App\Models\Setting;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function cart()
    {
        $carts = [];
        $enable_online_shop = Setting::where("key", "display_online_shop_product")->first();
        $session_id = Session::get('session_id');
        if (isset($enable_online_shop->value) && $enable_online_shop->value == "no") {
            if (!empty($session_id)) {
                $res = Cart::where('session_id', $session_id)->delete();
            }
            abort(404);
        }
        if (!empty($session_id)) {
            $carts = Cart::where("session_id", $session_id)->get();
        }

        $store = Store::where('is_online', '=', 'yes')->first();
        $tax_items = "No VAT";
        $id_store = 0;
        if ($store != NULL) {
            $tax_items = $store->vat_type;
            $id_store = $store->id;
        }
        if ($tax_items == NULL)
            $tax_items = "No VAT";

        foreach ($carts as &$cart) {
            $variation = NULL;
            $variation_value_final = [];
            if (!empty($cart->product_variation_id)) {
                $variation = ProductVariation::find($cart->product_variation_id);

                if ($variation != NULL) {
                    $variation_value = $variation->getVariationAttributes();
                    if ($variation_value) {
                        foreach ($variation_value as $k => $v) {
                            $attr = Attribute::find($k);
                            $attr_val = AttributeValue::find($v);
                            if ($attr_val != NULL && $attr != NULL)
                                $variation_value_final = array_merge($variation_value_final, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                        }
                    }
                }
            }
            $cart->variation = $variation;
            $cart->variation_value = $variation_value_final;

            $cart->product_image = Product_image::where('products_id', $cart->product_id)->first();
        }

        $headerMenus = HeaderMenu::where('parent', 0)->orderBy('position', 'asc')->get();
        foreach ($headerMenus as &$lowerPriorityHeaderMenu) {
            $children = HeaderMenu::where('parent', $lowerPriorityHeaderMenu->id)->orderBy('position', 'asc')->get();
            foreach ($children as &$item_children) {
                $child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                if (sizeof($child_of_child) > 0) {
                    $item_children->child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                    foreach ($item_children->child_of_child as $item_children_child) {
                        $child_of_childrens = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        if (sizeof($child_of_childrens) > 0) {
                            $item_children_child->child_of_childrends = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        }
                    }
                }
            }
            $lowerPriorityHeaderMenu->children = $children;
        }
        $headerMenuColor = HeaderMenuColor::latest()->first();
        $delivery = Delivery::where('is_active', '=', 'yes')->get();
        $stores = Store::where('pickup_location', '=', 'yes')->get();

        $company = Company::latest()->first();

        $payment_mode = PayementMethodSales::where('is_on_online_shop_order', "yes")->get();
        $shop_name = Setting::where("key", "store_name_meta")->first();
        $shop_description = Setting::where("key", "store_description_meta")->first();
        $online_store = Store::where('is_online', '=', 'yes')->first();
        $shop_name = Setting::where("key", "store_name_meta")->first();
        $shop_description = Setting::where("key", "store_description_meta")->first();
        $code_added_header = Setting::where("key", "code_added_header")->first();

        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key", "store_favicon")->first()) {
            $shop_favicon_db = Setting::where("key", "store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        } else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon = $company->logo;
        }

        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();

        return view('cart.cart', compact([
            'carts',
            'headerMenuColor',
            'headerMenus',
            'shop_favicon',
            'tax_items',
            'id_store',
            'payment_mode',
            'delivery',
            'stores',
            'company',
            'shop_name',
            'shop_description',
            'online_store',
            'shop_name',
            'shop_description',
            'code_added_header',
            'ebs_typeOfPerson'
        ]));
    }

    public function addCart(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            // Check stock not ready
            $store = Store::where('is_online', '=', 'yes')->first();
            $tax_items = "No VAT";
            if ($store != NULL)
                $tax_items = $store->vat_type;
            if ($tax_items == NULL)
                $tax_items = "No VAT";

            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }

            $product_variation_id = NULL;
            if (isset($data['product_variation_id']) && !empty($data['product_variation_id'])) {
                $product_variation_id = $data['product_variation_id'];
            }

            $line = NULL;

            if ($product_variation_id == NULL) {
                $line = Cart::where('session_id', $session_id)
                    ->where('product_id', $data['product_id'])
                    ->whereNull('product_variation_id')
                    ->first();
            } else {
                $line = Cart::where('session_id', $session_id)
                    ->where('product_id', $data['product_id'])
                    ->where('product_variation_id', $product_variation_id)
                    ->first();
            }

            // Check if item exists in cart
            if ($line == NULL) {
                $item = new Cart([
                    'session_id' => $session_id,
                    'product_id' => $data['product_id'],
                    'product_variation_id' => $product_variation_id,
                    'product_name' => $data['product_name'],
                    'product_price' => $data['product_price'],
                    'quantity' => $data['quantity'],
                    'tax_sale' => $data['tax_sale'],
                    'have_stock_api' => $data['have_stock_api'],
                    'tax_items' => $tax_items
                ]);
                $item->save();
            } else {
                $line->update([
                    'quantity' => $line->quantity + $data['quantity']
                ]);
            }

            // Return a JSON response for the AJAX request
            return response()->json([
                'success' => true,
                'message' => 'Item has been added to cart.',
                'checkout_url' => url('cart'),
                'add_another_url' => url('')
            ]);
        }

        // If the method is not POST, return an error response
        return response()->json([
            'success' => false,
            'message' => 'Invalid request method.'
        ], 405);
    }

    public function delete_cart($id)
    {
        $post = Cart::find($id);
        $post->delete();

        return redirect()->back()->with('success', 'Item has been deleted from cart')->withInput();
    }

    public function delete_cart_ajax($id)
    {
        $post = Cart::find($id);
        $post->delete();

        echo json_encode(['msg' => 'Item has been deleted from cart', 'error' => false]);
        die;
    }

    public function empty_cart()
    {
        $session_id = Session::get('session_id');
        if (!empty($session_id)) {
            $res = Cart::where("session_id", $session_id)->delete();
        }
        return redirect()->back()->with('success', 'Cart empty!');
    }
}
