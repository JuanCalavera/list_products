<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();
        foreach($products as $product){
            $allProducts[] = [$product->toArray(), 'external_reference' => $product->listProduct()->first()];
        }

        return json_encode($allProducts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return Products::create([
            'name_product' => $request->name_product,
            'quantity_product' => $request->quantity_product,
            'list_id' => $request->list_id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        return $products->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductsRequest  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products)
    {
        if (isset($request->name_product)) {
            if ($request->name_product != $products->name_product) {
                $oldName = $request->name_product;
                $products->name_product = $request->name_product;
                if ($products->save()) {
                    $return[] = ['name_message' => "O nome do produto foi atualizado de {$oldName} para {$products->name_product}"];
                } else {
                    $return[] = ['name_message' => "Houve um erro ao atualizar o nome do produto"];
                }
            }
        }
        if (isset($request->quantity_product)) {
            if ($request->quantity_product != $products->quantity_product) {
                $oldQuantity = $request->quantity_product;
                $products->quantity_product = $request->quantity_product;
                if ($products->save()) {
                    $return[] = ['quantity_message' => "A quantidade do produto foi atualizada de {$oldQuantity} para {$products->quantity_product}"];
                } else {
                    $return[] = ['quantity_message' => "Houve um erro ao atualizar a quantidade do produto"];
                }
            }
        }

        if(!empty($return)){
            return json_encode($return);
        } else if(empty($return)){
            return json_encode(['message' => 'Nada foi atualizado']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        $products->delete();
    }
}
