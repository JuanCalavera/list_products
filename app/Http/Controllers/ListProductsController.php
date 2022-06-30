<?php

namespace App\Http\Controllers;

use App\Models\ListProducts;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ListProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = ListProducts::all();
        if (count($lists) != 0) {
            foreach ($lists as $list) {
                $allLists['lists'][] = ['list' => $list, 'external_reference' => $list->products()->get()];
            }

            return Response::json($allLists);
        } else if (count($lists) == 0) {
            return Response::json(['message_error' => 'Você não possui listas cadastradas']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return ListProducts::create([
            'title' => $request->title,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ListProducts  $listProducts
     * @return \Illuminate\Http\Response
     */
    public function show(ListProducts $listProducts)
    {
        $products = $listProducts->products()->get();
        // return [->toArray(), ->toArray()];
        return Response::json(['list' => $listProducts, 'products' => $products]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateListProductsRequest  $request
     * @param  \App\Models\ListProducts  $listProducts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListProducts $listProducts)
    {
        $oldName = $listProducts->title;
        $listProducts->title = $request->title != $listProducts->title && isset($request->title) ? $request->title : $listProducts->title;
        if ($listProducts->title != $oldName) {
            if ($listProducts->save()) {
                return Response::json(['message' => "Alterado o título de {$oldName} para {$listProducts->title}"]);
            } else {
                return Response::json(['message' => "O título não foi alterado por favor tente novamente mais tarde"]);
            }
        } else if($listProducts->title == $oldName){
            return Response::json(['message' => "Nada foi atualizado pois não foi encontrado atualizações"]);
        }

        return Response::json(['message' => "O processo de atualização deu erro"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ListProducts  $listProducts
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListProducts $listProducts)
    {
        if (isset($listProducts)) {
            $oldName = $listProducts->title;
            $products = $listProducts->products()->get();
            foreach ($products as $product) {
                $deleteProduct = $product->name_product;
                if ($product->delete()) {
                    $return[] = ['message_product' => "Deletado o produto {$deleteProduct}"];
                } else {
                    $return[] = ['message_product' => "Problemas ao deletar o produto {$deleteProduct}"];
                }
            }
            if ($listProducts->delete()) {
                return Response::json(['message_list' => "Deletado a lista {$oldName}", 'products_deleted' => $return]);
            } else {
                return Response::json(['message_list' => "A lista não pode ser deletada por favor tente novamente mais tarde"]);
            }
        }
        return Response::json(['message_error' => "Nenhuma ação efetuada"]);
    }

    public function addProduct(ListProducts $listProducts, Request $request)
    {
        return Products::create([
            'name_product' => $request->name_product,
            'quantity_product' => $request->quantity_product,
            'list_id' => $listProducts->id,
        ]);
    }

    public function duplicateList(ListProducts $listProducts)
    {
        $newList = ListProducts::create([
            'title' => $listProducts->title,
        ]);

        if (isset($newList)) {
            $products = $listProducts->products()->get();

            foreach ($products as $product) {
                $newProducts[] = Products::create([
                    'name_product' => $product->name_product,
                    'quantity_product' => $product->quantity_product,
                    'list_id' => $newList->id,
                ]);
            }
            return Response::json(['new_list' => $newList, 'new_products' => $newProducts]);
        } elseif (!isset($newList)) {
            return Response::json(['error_message' => 'Não foi encontrada a lista para ser duplicada']);
        }
        return Response::json(['error_message' => 'Nenhuma ação foi executada']);
    }
}
