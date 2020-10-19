<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Support\Facades\Redirect;
use DB;

class CustomerController extends Controller
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
    		$clientes = DB::table('customers')->where('nombre', 'LIKE', '%'.$sql.'%')->orwhere('num_documento', 'LIKE', '%'.$sql.'%')->orderBy('id', 'desc')->paginate(3);
    		return view('clientes.index', [
    			"clientes" => $clientes,
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
    	$cliente = new Customer();
    	$cliente->nombre = $request->nombre;
    	$cliente->tipo_documento = $request->tipo_documento;
    	$cliente->num_documento = $request->num_documento;
    	$cliente->direccion = $request->direccion;
    	$cliente->telefono = $request->telefono;
    	$cliente->email = $request->email;

    	$cliente->save();
    	return Redirect::to("cliente");

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
    	$cliente = Customer::findOrFail($request->id_cliente);
    	$cliente->nombre = $request->nombre;
    	$cliente->tipo_documento = $request->tipo_documento;
    	$cliente->num_documento = $request->num_documento;
    	$cliente->direccion = $request->direccion;
    	$cliente->telefono = $request->telefono;
    	$cliente->email = $request->email;
    	
    	$cliente->save();
    	return Redirect::to("cliente");
    }
}
