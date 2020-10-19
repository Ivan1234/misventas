<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Provider;
use DB;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

    	if($request){

    		$sql=trim($request->get('buscarTexto'));
    		$proveedores = DB::table('providers')->where('nombre', 'LIKE', '%'.$sql.'%')->orwhere('num_documento', 'LIKE', '%'.$sql.'%')->orderBy('id', 'desc')->paginate(3);
    		return view('proveedores.index', [
    			"proveedores" => $proveedores,
    			"buscarTexto" => $sql
    		]);
    	}
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    	$proveedor = new Provider();
    	$proveedor->nombre = $request->nombre;
    	$proveedor->tipo_documento = $request->tipo_documento;
        $proveedor->num_documento = $request->num_documento;
    	$proveedor->direccion = $request->direccion;
    	$proveedor->telefono = $request->telefono;
    	$proveedor->email = $request->email;

    	$proveedor->save();
    	return Redirect::to("proveedor");

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    	$proveedor = Provider::findOrFail($request->id_proveedor);
		$proveedor->nombre = $request->nombre;
    	$proveedor->tipo_documento = $request->tipo_documento;
        $proveedor->num_documento = $request->num_documento;
    	$proveedor->direccion = $request->direccion;
    	$proveedor->telefono = $request->telefono;
    	$proveedor->email = $request->email;
    	
    	$proveedor->save();
    	return Redirect::to("proveedor");
    }
}
