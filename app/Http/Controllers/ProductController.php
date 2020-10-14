<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use DB;

class ProductController extends Controller
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
    		$productos = DB::table('products as p')->join('categories as c', 'p.idcategoria', '=', 'c.id')->select('p.id', 'p.idcategoria', 'p.nombre', 'p.precio_venta', 'p.codigo', 'p.stock', 'p.imagen', 'p.condicion', 'c.name as categoria')->where('p.nombre', 'LIKE', '%'.$sql.'%')->orwhere('p.codigo', 'LIKE', '%'.$sql.'%')->orderBy('p.id', 'desc')->paginate(3);
    		/*Listar las categorias en ventana modal*/
    		$categorias = DB::table('categories')->select('id', 'name', 'description')->where('condition', '=', '1')->get();

    		return view('producto.index', [
    			"productos" => $productos,
    			"categorias" => $categorias,
    			"buscarTexto" => $sql
    		]);

    		//return $productos;
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
    	$producto = new Product();
    	$producto->idcategoria = $request->id;
    	$producto->codigo = $request->codigo;
    	$producto->nombre = $request->nombre;
    	$producto->precio_venta = $request->precio_venta;
    	$producto->stock = '0';
    	$producto->condicion = '1';

        //Handle File Upload
        if($request->hasFile('imagen')){

            /*Obtiene el nombre de la imagen con la extensión*/
            $filenamewithExt = $request->file('imagen')->getClientOriginalName();

            /*Obtiene el solo el nombre del archivo*/
            $filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);

            /*Obtiene solo la extensión*/
            $extension = $request->file('imagen')->guessClientExtension();

            /*Nuevo nombre del archvio*/
            $fileNameToStore = time().'.'.$extension;

            /*Subir imagen*/
            $path = $request->file('imagen')->storeAs('public/img/producto', $fileNameToStore);
        }
        else{
            $fileNameToStore = "noimagen.jpg";
        }

        $producto->imagen = $fileNameToStore;

    	$producto->save();
    	return Redirect::to("producto");

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
    	$producto = Product::findOrFail($request->id_producto);
    	$producto->idcategoria = $request->id;
    	$producto->codigo = $request->codigo;
    	$producto->nombre = $request->nombre;
    	$producto->precio_venta = $request->precio_venta;
    	$producto->stock = '0';
    	$producto->condicion = '1';

        if($request->hasFile('imagen')){
            /*Si la imagen que subes es distinta a la que esta por defecto entonces eliminaría la imagen anterior, eso para evitar acumular imagenes en el servidor*/
            if($producto->imagen != "noimagen.jpg"){
                Storage::delete('public/img/producto/'.$producto->imagen);
            }

            $filenamewithExt = $request->file('imagen')->getClientOriginalName();

            $filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);

            $extension = $request->file('imagen')->guessClientExtension();

            $fileNameToStore = time().'.'.$extension;

            $path = $request->file('imagen')->storeAs('public/img/producto', $fileNameToStore);
        }
        else{
            $fileNameToStore = $producto->imagen;
        }

        $producto->imagen = $fileNameToStore;

    	$producto->save();
    	return Redirect::to("producto");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // 
    	$producto = Product::findOrFail($request->id_producto);

    	if($producto->condicion=="1"){

    		$producto->condicion= '0';
    		$producto->save();
    		return Redirect::to("producto");

    	} else{

    		$producto->condicion= '1';
    		$producto->save();
    		return Redirect::to("producto");

    	}
    }
}
