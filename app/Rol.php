<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $table = ['nombre', 'descripcion', 'condicion'];
    public $timestamps = false;
}
