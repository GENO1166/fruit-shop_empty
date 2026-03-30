<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = DB::table('products')->get();

        $userid = Auth::id();
        $user_role = DB::table('users')->where('id', $userid)->select('role')->first();

        if($user_role == 'user')
        {
            return redirect()->back();
        }
        
        return view('product.product_manage', compact('products', 'user_role'));
    }

    public function create_product()
    {
        $userid = Auth::id();
        
        $user_role = DB::table('users')->where('id', $userid)->select('role')->first();

        if ($user_role->role == 'user') {
            return redirect()->back()->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        return view('product.product_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name'  => 'required|string|max:255',
            'description'   => 'required|string',
            'price'         => 'required|numeric|min:0',
            'status'        => 'required|in:active,inactive,out_of_stock',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            $image->storeAs('product_images', $imageName, 'public');
        }

        DB::table('products')->insert([
            'product_name' => $request->product_name,
            'description'  => $request->description,
            'price'        => $request->price,
            'image'        => $imageName,
            'status'       => $request->status,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect()->route('products_manage')->with('success', 'เพิ่มสินค้าใหม่เรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        return view('product.product_edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name'  => 'required|string|max:255',
            'description'   => 'required|string',
            'price'         => 'required|numeric|min:0',
            'status'        => 'required|in:active,inactive,out_of_stock',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $updateData = [
            'product_name' => $request->product_name,
            'description'  => $request->description,
            'price'        => $request->price,
            'status'       => $request->status,
            'updated_at'   => now(),
        ];

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            $image->storeAs('product_images', $imageName, 'public');

            $oldProduct = DB::table('products')->where('id', $id)->first();
            if ($oldProduct && $oldProduct->image) {
                Storage::disk('public')->delete('product_images/' . $oldProduct->image);
            }

            $updateData['image'] = $imageName;
        }

        DB::table('products')->where('id', $id)->update($updateData);

        return redirect()->route('products_manage')->with('success', 'อัปเดตข้อมูลสินค้าเรียบร้อยแล้ว');
    }

    public function delete($product_id)
    {        
        $userid = Auth::id();
        
        $user_role = DB::table('users')->where('id', $userid)->select('role')->first();

        if ($user_role->role == 'user') {
            return redirect()->back()->with('error', 'คุณไม่มีสิทธิ์ลบรายการนี้');
        }

        $package = DB::table('products')->where('id', $product_id)->first();

        if ($package) {
            $fileName = $package->image;

            if ($fileName && Storage::disk('public')->exists('packages/' . $fileName)) {
                Storage::disk('public')->delete('packages/' . $fileName);
            }

        }

        DB::table('products')->where('id', $product_id)->delete();

        return redirect()->route('products_manage')->with('success', 'ลบรายการนี้เรียบร้อยแล้ว');
    }

    public function show_product(Request $request)
    {
        $query = DB::table('products')
            ->where('status', '!=', 'inactive');

        if ($request->has('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(8);

        return view('product_list', compact('products'));
    }

    public function show_product_E()
    {

        return view('product_list_E');
    }


    public function add_to_cart(Request $request, $product_id)
    {
        $product = DB::table('products')->where('id', $product_id)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลสินค้า');
        }

        $request_quantity = $request->product_quantity ?? 1;

        $cart = DB::table('cart')
                ->where('user_id', Auth::id())
                ->where('status', '0')
                ->first();

        if (!$cart) {
            $cart_id = DB::table('cart')->insertGetId([
                'user_id' => Auth::id(),
                'status' => '0',
                'created_at' => now()
            ]);
        } else {
            $cart_id = $cart->id;
        }

        $existingCartItem = DB::table('cartdetails')
                    ->where('carts_id', $cart_id)
                    ->where('product_id', $product_id)
                    ->first();
                
        if (!$existingCartItem) {
            DB::table('cartdetails')->insert([
                'carts_id' => $cart_id,
                'product_id' => $product_id,
                'quantity' => $request_quantity,
                'add_date' => now(),
            ]);
        } else {
            DB::table('cartdetails')
                ->where('carts_id', $cart_id)
                ->where('product_id', $product_id)
                ->update([
                    'quantity' => $existingCartItem->quantity + $request_quantity,
                    'add_date' => now(),
                ]);
        }
        
        return redirect()->back()->with('success', 'เพิ่ม ' . $product->product_name . ' ลงตะกร้าเรียบร้อยแล้ว');
    }

}
