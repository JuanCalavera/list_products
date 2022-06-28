<?php

namespace App\Http\Controllers;

use App\Models\ListProducts;
use Illuminate\Http\Request;

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
        foreach($lists as $list){
            $allLists[] = [$list->toArray(), 'external_reference' => $list->products()->get()];
        }

        return json_encode($allLists);
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
        return $listProducts->toJson();
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

        if ($request->title != $listProducts->title) {
            $oldName = $listProducts->title;
            $listProducts->title = $request->title;
            if ($listProducts->save()) {
                return ['message' => "Alterado o título de {$oldName} para {$listProducts->title}"];
            } else {
                return ['message' => "O título não pode ser alterado por favor tente novamente mais tarde"];
            }
        } else {
            return ['message' => "O título informado é igual ao que já está cadastrado"];
        }

        return ['message' => "O processo de atualização deu erro"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ListProducts  $listProducts
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListProducts $listProducts)
    {
        $oldName = $listProducts->title;
        if ($listProducts->delete()) {
            return ['message' => "Deletado a lista {$oldName}"];
        } else {
            return ['message' => "A lista não pode ser deletada por favor tente novamente mais tarde"];
        }
    }
}
