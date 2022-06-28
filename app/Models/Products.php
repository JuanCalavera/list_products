<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_product',
        'quantity_product',
        'list_id',
    ];

    public function listProduct()
    {
        return $this->hasOne(ListProducts::class, 'id', 'list_id');
    }
}
