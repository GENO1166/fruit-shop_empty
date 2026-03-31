<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function test1_page()
    {
        return view('test1');
    }

    public function test2_page(Request $request)
    {
        $name = $request->name;
        $price = $request->price;
        $detail = $request->detail;


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            $image->storeAs('test_images', $imageName, 'public');
        }

        return view('test2', compact('name', 'price', 'detail', 'imageName'));
    }
}
