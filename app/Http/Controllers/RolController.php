<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;
use DB;

class RolController extends Controller
{
    public function index(Request $request)
    {
    	if($request)
    	{
    		//La función trim elimina los espacios en blanco del principio y al final de la cadena
    		$sql = trim($request->get('buscarTexto'));
    		$roles = DB::table('roles')->where('nombre', 'LIKE', '%'.$sql.'%')->orderBy('id', 'desc')->paginate(3);
    		return view('roles.index', [
    			'roles' => $roles,
    			'buscarTexto' => $sql
    		]);
    	}
    }
}
