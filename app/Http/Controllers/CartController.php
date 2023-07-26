<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart/index');
    }

    public function add(Request $request, Product $product)
    {
        Cart::instance('cart')->add(
            $product,
            $request->get('quantity', 1)
        );

        return redirect()->back();
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'rowId' => ['required', 'string']
        ]);

        Cart::instance('cart')->remove($data['rowId']);

        return redirect()->back();
    }

    /**
     * Uodate count per product inside cart
     */
    public function countUpdate(Request $request, Product $product)
    {   
        $rowId = null;
        foreach (Cart::instance('cart')->content() as $item) {
            if ($item->id === $product->id) {
                $rowId = $item->rowId;
            }
        }
        if(!is_null($rowId))
        Cart::instance('cart')->update(
            $rowId,
            $request->get('quantity')
        );

        return redirect()->back();
    }
}
