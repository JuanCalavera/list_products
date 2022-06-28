<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListProducts extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function products()
    {
        return $this->hasMany(Products::class, 'list_id', 'id');
    }
}
