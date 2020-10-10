<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //
    protected $table = 'categories';

    protected $fillable = ['name','description','condition'];
}
