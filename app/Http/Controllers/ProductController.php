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
        $search_variant = $request->variant ?? "";
        
     
        if($search_title !='' && $search_price_from != "" && $search_price_to!="" && $search_date !=""){
            $data = DB::table('products')
            ->join('product_variants','products.id','=','product_variants.product_id') 
            ->join('product_variant_prices','products.id','=','product_variant_prices.product_id') 
            ->where('products.title', '=', $search_title)
            ->where('product_variants.variant', '=', $search_variant)
            ->where('product_variant_prices.price', '>=', $search_price_from)
            ->where('product_variant_prices.price', '<', $search_price_to)
            ->where('products.created_at', '<=', $search_date)
            ->paginate(10);

            $data_count = DB::table('products')
            ->join('product_variants','products.id','=','product_variants.product_id') 
            ->join('product_variant_prices','products.id','=','product_variant_prices.product_id') 
            ->where('products.title', '=', $search_title)
            ->where('product_variants.variant', '=', $search_variant)
            ->where('product_variant_prices.price', '>=', $search_price_from)
            ->where('product_variant_prices.price', '<', $search_price_to)
            ->where('products.created_at', '<=', $search_date)
            ->count();

            $all_product = DB::table('products')
                            ->select('id')
                            ->get();
            $variants = Variant::all();
            $count = DB::table('products')->count();

            $variants_attr = DB::table('variants')
                            ->join('product_variants','variants.id','=','product_variants.variant_id')
                            ->select('variants.title as variant_title', 'product_variants.variant as variant_name')
                            ->distinct()
                            ->get();
                            
                            
            return view('products.index',['all_products_data'=>$data,'all_product_id'=>$all_product, 'variants'=>$variants,'variants_attr'=>$variants_attr,'count'=>$count, 
            'data_count'=>$data_count]);
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
        
            return view('products.index',['all_products_data'=>$data,'all_product_id'=>$all_product, 'variants'=>$variants,'variants_attr'=>$variants_attr, 'count'=>$count, 'data_count'=>""]);
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

        return view('products.create',['variants' => $variants]);
        // return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $id='')
    {   
        if($id!=0){
            //edit existing product
            $request->validate([
                'title'=>'required',
                'sku'=>'required',
                'description'=>'required',
            ]);
            $product_model = Product::find($id);
            $product_model->title= $request->post('title');
            $product_model->sku= $request->post('sku');
            $product_model->description= $request->post('description');
            $product_model->save();

            $request->session()->flash('message', 'Product updated successfully');
            return redirect()->route('product.index');
        }else{
            //add new product
            $request->validate([
                'title'=>'required',
                'sku'=>'required',
                'description'=>'required',
                'variant'=>'required',
                'price'=>'required',
                'stock'=>'required',
            ]);
            //product data save start//
        
            $product_model = new Product();
            $product_model->title= $request->post('title');
            $product_model->sku= $request->post('sku');
            $product_model->description= $request->post('description');
            $product_model->save();
            $product_id = $product_model->id;
    
        
            //product data save ends//
            
            //variant data save start//
            $variant_id_arr = $request->post('variant_id');
            $variant_arr = $request->post('variant');
            $price_arr = $request->post('price');
            $stock_arr = $request->post('stock');
            foreach($variant_id_arr as $key=>$val){
                $product_variant_model = new ProductVariant();
                $product_variant_model->product_id =$product_id;
                $product_variant_model->variant =$variant_arr[$key];
                $product_variant_model->variant_id =$variant_id_arr[$key];
                $product_variant_model->save();
                $variant_id = $product_variant_model->id;           
    
                if($val==1){
                    $product_variant_price_model = new ProductVariantPrice();
                    $product_variant_price_model->product_variant_one = $variant_id;
                    $product_variant_price_model->product_id = $product_id;
                    $product_variant_price_model->stock = $stock_arr[$key];
                    $product_variant_price_model->price = $price_arr[$key];
                    $product_variant_price_model->save();
    
                }elseif($val==2){
                    $product_variant_price_model = new ProductVariantPrice();
                    $product_variant_price_model->product_variant_two = $variant_id;
                    $product_variant_price_model->product_id = $product_id;
                    $product_variant_price_model->stock = $stock_arr[$key];
                    $product_variant_price_model->price = $price_arr[$key];
                    $product_variant_price_model->save();
    
                }else{
                    $product_variant_price_model = new ProductVariantPrice();
                    $product_variant_price_model->product_variant_three = $variant_id;
                    $product_variant_price_model->product_id = $product_id;
                    $product_variant_price_model->stock = $stock_arr[$key];
                    $product_variant_price_model->price = $price_arr[$key];
                    $product_variant_price_model->save();
                }
            }
        }
        //variant data save end//
        $request->session()->flash('message', 'New product added successfully');
        return redirect()->route('product.index');
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
    public function edit(Product $product,$id)
    {
        $arr = Product::find($id);
        if( $arr !=""){
            $result['id'] = $arr->id;
            $result['title'] = $arr->title;
            $result['sku'] = $arr->sku;
            $result['description'] = $arr->description;
        
            return view('products.edit',$result);
        }else{
            $request->session()->flash('err_message', 'Data not found');
            return redirect()->route('product.index');
        }
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
