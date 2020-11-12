<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
    	if($request)
    	{
    		//Primero checa que el campo "idrol" de la tabla users coincida con el campo "id" de la tabla roles, luego manda a traer todos los campos de la tabla users así como el campo "nombre" de la tabla roles y los acomodará de manera descendente segun coincida el nombre de los usuarios con lo ingresado en el formulario html.
    		$sql = trim($request->get('buscarTexto'));
    		$usuarios = DB::table('users')
    		->join('roles', 'users.idrol', '=', 'roles.id')
    		->select('users.id', 'users.nombre', 'users.tipo_documento', 'users.num_documento', 'users.email', 'users.direccion', 'users.telefono', 'users.usuario', 'users.password', 'users.condicion', 'users.idrol', 'users.imagen', 'roles.nombre as rol')->where('users.nombre', 'LIKE', '%'.$sql.'%')->orderBy('users.id', 'desc')->paginate(3);

    		//Listas los roles de la ventana modal
    		$roles = DB::table('roles')->select('id', 'nombre', 'descripcion')->where('condicion', '=', '1')->get();

    		return view('users.index', [
    			'usuarios' => $usuarios,
    			'roles' => $roles,
    			'buscarTexto' => $sql
    		]);
    	}
    }

    public function store(Request $request)
    {
    	$user = new User();
    	$user->nombre = $request->nombre;
    	$user->tipo_documento = $request->tipo_documento;
    	$user->num_documento = $request->num_documento;
    	$user->telefono = $request->telefono;
    	$user->email = $request->email;
    	$user->direccion = $request->direccion;
    	$user->usuario = $request->usuario;
    	$user->password = bcrypt($request->password);
    	$user->condicion = '1';
    	$user->idrol = $request->id_rol;

    	if($request->hasFile('imagen'))
    	{
    		$filenamewithExt = $request->file('imagen')->getClientOriginalName();
    		$filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);
    		$extension = $request->file('imagen')->guessClientExtension();
    		$filenameToStore = time().'.'.$extension;
    		$path = $request->file('imagen')->storeAs('public/img/usuario', $filenameToStore);
    	}
    	else{
    		$filenameToStore = 'noimagen.jpg';
    	}

    	$user->imagen = $filenameToStore;
    	$user->save();
    	return Redirect::to('user');
    }

    public function update(Request $request)
    {
    	$user = User::findOrFail($request->id_usuario);
    	$user->nombre = $request->nombre;
    	$user->tipo_documento = $request->tipo_documento;
    	$user->num_documento = $request->num_documento;
    	$user->direccion = $request->direccion;
    	$user->telefono = $request->telefono;
    	$user->email = $request->email;
    	$user->usuario = $request->usuario;
    	$user->password = bcrypt($request->password);
    	$user->condicion = '1';
    	$user->idrol = $user->idrol;

    	if($request->hasFile('imagen'))
    	{
    		if($user->imagen != 'noimagen.jpg')
    		{
    			Storage::delete('public/img/usuario'.$user->imagen);
    		}

    		$filenamewithExt = $request->file('imagen')->getClientOriginalName();
    		$filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);
    		$extension = $request->file('imagen')->guessClientExtension();
    		$filenameToStore = time().'.'.$extension;
    		$path = $request->file('imagen')->storeAs('public/img/usuario', $filenameToStore);
    	}
    	else{
    		$filenameToStore = $user->imagen;
    	}

    	$user->imagen = $filenameToStore;
    	$user->save();
    	return Redirect::to('user');
    }

    public function destroy(Request $request)
    {
    	$user = User::findOrFail($request->id_usuario);

    	if($user->condicion == '1')
    	{
    		$user->condicion = '0';
    		$user->save();
    		return Redirect::to('user');
    	}else{
    		$user->condicion = '1';
    		$user->save();
    		return Redirect::to('user');
    	}
    }
}
