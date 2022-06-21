<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {   

        $search_title = $request->title ?? "";
        $search_price_from = $request->price_from ?? "";
        $search_price_to = $request->price_to ?? "";
        $search_date = $request->date ?? "";

        if($search_title !='' && $search_price_from != "" && $search_price_to!="" && $search_date !=""){
            $data = DB::table('products')
            ->join('product_variants','products.id','=','product_variants.product_id') 
            ->join('product_variant_prices','products.id','=','product_variant_prices.product_id') 
            ->where('products.title', '=', 'search_title')
            ->get();
            return $data;
        }else{
            $count = DB::table('products')->count();
            $all_product = DB::table('products')
                            ->select('id')
                            ->get();
            $data = DB::table('products')
                            ->join('product_variants','products.id','=','product_variants.product_id') 
                            ->join('product_variant_prices','products.id','=','product_variant_prices.product_id')                        
                            ->paginate(10);
            $variants = Variant::all();
    
            $variants_attr = DB::table('variants')
                            ->join('product_variants','variants.id','=','product_variants.variant_id')
                            ->select('variants.title as variant_title', 'product_variants.variant as variant_name')
                            ->distinct()
                            ->get();
        
            return view('products.index',['all_products_data'=>$data,'all_product_id'=>$all_product, 'variants'=>$variants,'variants_attr'=>$variants_attr, 'count'=>$count]);
        }
       
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
     */
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
        //
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
