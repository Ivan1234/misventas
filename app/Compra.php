<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    protected $fillable = ['idproveedor', 'idusuario', 'tipo_identificacion', 'num_compra', 'fecha_compra', 'impuesto', 'total', 'estado'];

    //Es el usuario que hace el registro
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    //Es el proveedor que hace la compra
    public function proveedor()
    {
    	return $this->belongsTo('App\Provider');
    }
}
