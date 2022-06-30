<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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
        if (count($products) != 0) {
            foreach ($products as $product) {
                $allProducts['lists'][] = ['list' => $product, 'external_reference' => $product->listProduct()->first()];
            }
            return Response::json($allProducts);
        } else if (count($products) == 0) {
            return Response::json(['message_error' => 'Você não possui produtos cadastrados']);
        }
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
        return Response::json(['product' => $products->toArray(), 'external_reference' => $products->listProduct()->first()->toArray()]);
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
        $oldName = $products->name_product;
        $products->name_product = $request->name_product != $products->name_product && isset($request->name_product) ? $request->name_product : $products->name_product;
        if ($products->name_product != $oldName) {
            if ($products->save()) {
                $return[] = ['name_message' => "O nome do produto foi atualizado de {$oldName} para {$products->name_product}"];
            } else {
                $return[] = ['name_message' => "Houve um erro ao atualizar o nome do produto"];
            }
        }

        $oldQuantity = $products->quantity_product;
        $products->quantity_product = $request->quantity_product != $products->quantity_product && isset($request->quantity_product) ? $request->quantity_product : $products->quantity_product;
        if ($oldQuantity != $products->quantity_product) {
            if ($products->save()) {
                $return[] = ['quantity_message' => "A quantidade do produto foi atualizada de {$oldQuantity} para {$products->quantity_product}"];
            } else {
                $return[] = ['quantity_message' => "Houve um erro ao atualizar a quantidade do produto"];
            }
        }

        if (!empty($return)) {
            return Response::json(['messages' => $return]);
        } else if (empty($return)) {
            return Response::json(['message' => 'Nada foi atualizado']);
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
        $oldName = $products->name_product;
        if ($products->delete()) {
            return Response::json(['message' => "Deletado o produto {$oldName}"]);
        } else {
            return Response::json(['message' => "A lista não pode ser deletada por favor tente novamente mais tarde"]);
        }
    }
}
