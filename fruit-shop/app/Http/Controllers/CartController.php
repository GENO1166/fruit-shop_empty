<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index($userid)
    {
        if ($userid != Auth::id())
        {
            return redirect()->back()->with('error', 'คุณไม่มีสิทธิ์เข้าถึงข้อมูลนี้');
        }

        $usercart = DB::table('cart')
                ->where('user_id', $userid)
                ->where('status', '0')
                ->first();

        if (!$usercart) {
            DB::table('cart')->insert([
                'user_id' => $userid,
                'status' => '0',
                'created_at' => now()
            ]);
            $cartItems = collect();
        } else {
            $cartItems = DB::table('cartdetails')
                ->leftJoin('products', 'products.id', '=', 'cartdetails.product_id')
                ->where('carts_id', $usercart->id)
                ->select(
                    'products.id as product_id',
                    'products.product_name',
                    'products.price',
                    'products.image',
                    'cartdetails.id as detail_id',
                    'cartdetails.quantity'
                )
                ->get();
        }

        $total = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        
        return view('cart', compact('cartItems', 'total', 'usercart'));
    }

    public function quantity_cart(Request $request, $cartid, $product_id)
    {
        $q = $request->action;
        // dd($q);
        if ($q == 'increase') {
            DB::table('cartdetails')
                ->where('carts_id', $cartid)
                ->where('product_id', $product_id)
                ->increment('quantity', 1);

        } elseif ($q == 'decrease') {

            $item = DB::table('cartdetails')->where('product_id', $product_id)->first();

            if ($item && $item->quantity > 1) {
                DB::table('cartdetails')
                    ->where('carts_id', $cartid)
                    ->where('product_id', $product_id)
                    ->decrement('quantity', 1);
            }
        }

        return redirect()->back();
    }

    public function delete_cart($cartid, $product_id)
    {
        $cart = DB::table('cart')
            ->where('id', $cartid)
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart) {
            return redirect()->back()->with('error', 'คุณไม่มีสิทธิ์ลบรายการนี้');
        }

        $item = DB::table('cartdetails')
            ->where('carts_id', $cartid)
            ->where('product_id', $product_id)
            ->first();

        if (!$item) {
            return redirect()->back()->with('error', 'ไม่พบสินค้าในตะกร้า');
        }

        DB::table('cartdetails')
            ->where('carts_id', $cartid)
            ->where('product_id', $product_id)
            ->delete();

        return redirect()->back()->with('success', 'ลบสินค้าออกจากตะกร้าแล้ว');
    }
}
