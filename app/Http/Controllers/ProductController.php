<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use Carbon\Doctrine\CarbonType;
use Illuminate\Support\Carbon as SupportCarbon;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('products.index', compact('products'));
        // return view('products.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'sku'=>'required',
            'description'=>'required',
        ]);
        Product::insert([
            'title' =>$request->title,
            'sku' =>$request->sku,
            'description' =>$request->description,
            'created_at' =>Carbon::now(),
        ]);
        return redirect()->back()->with('Created Success');

    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     * */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Product $product)
    {
        $id= $request->id;

        $request->validate([
            'title'=>'required',
            'sku'=>'required',
            'description'=>'required',
        ]);

        Product::findOrFail($id)->update([
            'title' =>$request->title,
            'sku' =>$request->sku,
            'description' =>$request->description,
            'updated_at' =>Carbon::now(),
        ]);

        $notification=array(
            'message'=>'update Success',
            'alert-type'=>'success'
             );
        return redirect()->route('latest_news_create')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}