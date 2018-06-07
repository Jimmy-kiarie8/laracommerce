<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // var_dump($request->image); die;
        // return $request->all();        
        $product = new Product;
        $quantity = $request->quantity;
        $size = $request->size;
        $qsArray = [];
        $rows = count($quantity);
        // var_dump($rows);
        for ($i=0; $i < $rows; $i++) { 
           $qsArray[] = $size[0+$i].':'.$quantity[0+$i];
        // var_dump($qsArray);

        }
        // var_dump($qsArray); die;
        /*if ($request->hasFile('image')) {
            $imagename = time().$request->image->getClientOriginalName;
            $request->image->storeAs('public/products', $imagename);
        }
        $path_to_Store = '/storage/products/'.$imagename;
        $product->image = $path_to_Store;*/
        $product->category_id = $request->category_id;
        $product->quantity_size = $request->qsArray;
        $product->price = $request->price;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->sub_id = $request->sub_id;
        $product->brand_id = $request->brand_id;
        $product->list_price = $request->list_price;
        $product->user_id = Auth::id();
        $product->save();
        return $product;    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // return $request->all();
        $product = Product::find($request->id);
        $product->quantity_size = $quantity_size;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->sub_id = $request->sub_id;
        $product->brand_id = $request->brand_id;
        $product->list_price = $request->list_price;
        $product->save();
        return $product;    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function getproducts()
    {
        // $products = Product::all();
        $products = DB::table('products')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            // ->leftJoin('subcats', 'products.sub_id', '=', 'subcats.id')
            ->get();
        return json_decode(json_encode($products), true);
    }

    public function prodImage(Request $request, $id)
    {
        // return $request->all();
        if ($request->hasFile('image')) {
            $imagename = time().$request->image->getClientOriginalName;
            $request->image->storeAs('public/products', $imagename);
        }
        $path_to_Store = '/storage/products/'.$imagename;
        $product->image = $path_to_Store;
        return $path_to_Store;
    }
}
