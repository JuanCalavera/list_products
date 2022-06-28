<?php

namespace Tests\Feature;

use App\Models\ListProducts;
use App\Models\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function creation_list_in_base_db()
    {
        $title = 'Compras da vovó';

        if (ListProducts::create([
            'title' => $title,
        ])) {
            $json = [
                'message' => 'Lista criada com suscesso',
            ];
        } else {
            $json = [
                'message' => 'Lista não adicionada',
            ];
        }

        return json_encode($json);
    }

    /** @test */
    public function list_all_in_db()
    {
        $lists = ListProducts::all();

        return $lists->toJson();
    }

    /** @test */
    public function update_list_by_id()
    {
        $list = 1;
        $listQuery = ListProducts::where('id', $list)->first();
        $listQuery->title = 'Compras da mamãe';
        $listQuery->save();

        return $listQuery->toJson();
    }

    /** @test */
    public function delete_in_db_by_id()
    {
        $list = 3;
        $listQuery = ListProducts::where('id', $list)->first();
        $name = $listQuery->title;
        if ($listQuery->delete()) {
            $return = ['message' => "Deletada a Lista {$name}"];
        } else {
            $return = ['message' => "Não foi possível deletar a lista {$name}, verifique se o id foi inserido corretamente"];
        };

        return json_encode($return);
    }

    /** @test */
    public function duplicate_list_via_route()
    {
        $listProducts = ListProducts::where('id', 5)->first();

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
            return json_encode([$newList, $newProducts]);
        } elseif (!isset($newList)) {
            return json_encode(['error_message' => 'Não foi encontrada a lista para ser duplicada']);
        }
    }
}
