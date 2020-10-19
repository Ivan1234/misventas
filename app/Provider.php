<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
   protected $table = 'providers';

   protected $fillable = [' nombre', 'tipo_documento', 'num_documento', 'direccion', 'telefono', 'email'];
}
