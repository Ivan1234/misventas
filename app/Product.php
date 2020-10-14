<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = ['idcategoria', 'codigo', 'nombre', 'precio_venta', 'stock', 'condicion'];
}
