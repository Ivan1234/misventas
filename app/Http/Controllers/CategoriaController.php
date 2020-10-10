<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use Illuminate\Support\Facades\Redirect;
use DB;


class CategoriaController extends Controller
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
            $categorias=DB::table('categories')->where('name','LIKE','%'.$sql.'%')
            ->orderBy('id','desc')
            ->paginate(3);
            return view('categoria.index',["categorias"=>$categorias,"buscarTexto"=>$sql]);
            //return $categorias;
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
        $categoria= new Categoria();
        $categoria->name= $request->nombre;
        $categoria->description= $request->descripcion;
        $categoria->condition= '1';
        $categoria->save();
        return Redirect::to("categoria");
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
        $categoria= Categoria::findOrFail($request->id_categoria);
        $categoria->name= $request->nombre;
        $categoria->description= $request->descripcion;
        $categoria->condition= '1';
        $categoria->save();
        return Redirect::to("categoria");
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
            $categoria= Categoria::findOrFail($request->id_categoria);

            if($categoria->condition=="1"){
                
                $categoria->condition= '0';
                $categoria->save();
                return Redirect::to("categoria");
        
            } else{

                $categoria->condition= '1';
                $categoria->save();
                return Redirect::to("categoria");

            }
    }
}
