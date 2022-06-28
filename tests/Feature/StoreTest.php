<?php

namespace Tests\Feature;

use App\Models\ListProducts;
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

        if(ListProducts::create([
            'title' => $title,
        ])){
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
        if($listQuery->delete()){
            $return = ['message' => "Deletada a Lista {$name}"];
        } else {
            $return = ['message' => "Não foi possível deletar a lista {$name}, verifique se o id foi inserido corretamente"];
        };

        return json_encode($return);
    }

}
