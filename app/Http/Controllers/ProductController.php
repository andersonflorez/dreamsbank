<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Product;
use App\Vuetable\Facades\Vuetable;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::userId($request->user()->role == 'admin' ? null : $request->user()->id)->with('user');

        $data = Vuetable::of($products)
            ->addColumn('state_spanish', function ($product) {
                return $product->state == 'pending' ? 'Pendiente' : ($product->state == 'approved' ? 'Aprovado' : 'Negado');
            })
            ->make();
        return $this->respondWithData($data);
    }

    /**
     * Display a listing products approved
     *
     * @return \Illuminate\Http\Response
     */
    public function getProductsApproved(Request $request)
    {
        $products = Product::with('user')->userId($request->user()->role == 'admin' ? null : $request->user()->id)->approved()->get();
 
        return $this->respondWithData(["products" => $products->toArray()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product($request->all());
        $product->number = rand(1000000000, 9999999999);
        $product->user_id = $request->user()->id;

        if (!$product->save()) {
            return $this->respondHttp500();
        }

        return $this->respondHttp200([
            'message' => 'Se realizo la solicitud del producto'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $this->respondWithData($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        if($request->user()->role == "admin"){
            $product->fill($request->all());
            if (!$product->update()) {
                return $this->respondHttp500();
            }
    
            return $this->respondHttp200([
                'message' => 'Se actualizo el producto'
            ]);
        }
        else{
            return $this->respondHttp403();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (!$product->delete()) {
            return $this->respondHttp500();
        }

        return $this->respondHttp200([
            'message' => 'Se elimino el producto'
        ]);
    }
}
