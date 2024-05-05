<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('pages.user.cart', [
            'cart' => Cart::with('items')->where('user_id', auth()->user()->id)->first()
        ]);
    }

    public function store(Request $request)
    {
        if (auth()->user()->cart) {
            $cart = auth()->user()->cart;
        } else {
            $cart = new Cart();
            $cart->user_id = auth()->user()->id;
            $cart->save();
        }

        $item = CartItem::where('cart_id', $cart->id)->where('kode_product', $request->product)->first();
        if ($item) {
            $item->qty = $item->qty + $request->qty;
            $item->update();
        } else {
            $item = new CartItem();
            $item->cart_id = $cart->id;
            $item->kode_product = $request->product;
            $item->qty = $request->qty;
            $item->save();
        }


        return redirect()->back()->with('success', 'Berhasil menambah ke keranjang');
    }

    public function checkout()
    {
        $data = [
            'items' => auth()->user()->cartItems
        ];

        return view('pages.user.checkout', $data);
    }

    public function order(Request $request)
    {
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->alamat = $request->alamat;
        $order->no_telp = $request->no_telp;
        $order->kode_pos = $request->kode_pos;
        $order->payment = $request->payment;
        $order->status = 'Pending';
        $order->save();

        foreach (auth()->user()->cartItems as $item) {
            $oi = new OrderItem();
            $oi->order_id = $order->id;
            $oi->kode_product = $item->kode_product;
            $oi->qty = $item->qty;
            $oi->save();

            $product = Product::find($item->kode_product);
            $product->stok = $product - $item->qty;
            $product->update();
        }

        auth()->user()->cart->delete();

        return redirect()->route('orders')->with('success', 'Berhasil membuat pesanan');
    }
}
