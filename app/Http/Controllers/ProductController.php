<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        
        return response()->json([
            'data'=>$products,
            'status'=>true
            ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required',
            'description' => 'required']); 

        $createProduct = Product::create($request->all());

        return response()->json([
            'data'=>$createProduct,
            'status'=>true,
            'message'=>'product created successfully'
            ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable',
            'slug' => 'nullable',
            'price' => 'nullable',
            'description' => 'nullable']);

        $product = Product::find($id);
        if (!empty($product)) {
            $product->update($request->all());
        return response()->json([
            'data'=>$product,
            'status'=>true,
            'message'=>'product updated successfully'
            ],201);
    } else {
        return response()->json([
            'data'=>null,
            'status'=>false,
            'message'=>'product not found'
            ],404);

    }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return response()->json([
            'data'=>null,
            'status'=>true,
            'message'=>'product deleted successfully'],201);
    }


    /**
     * Search fot items.
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Product::where('name', 'like', '%'.$name.'%')->get();
    }
}
