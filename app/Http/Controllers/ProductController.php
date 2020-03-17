<?php

namespace App\Http\Controllers;
use App\ProductModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
       $pro = ProductModel::all();//inRandomOrder()->take(6)->get();
       return view("products.index")->with('products', $pro);
    }

    public function show($slug)
    {
        $pro = ProductModel::where('slug', $slug)->firstOrFail();
        return view('products.show')->with('data', $pro);
    }
}
