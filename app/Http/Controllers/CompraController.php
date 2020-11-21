<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Compra;
use App\DetalleCompra;
use Illuminate\Support\Facades\Redirect;

class CompraController extends Controller
{
	public function index(Request $request)
	{
		if($request)
		{
			$sql = trim($request->get('buscarTexto'));
			$compras = Compra::join('providers', 'compras.idproveedor', '=', 'providers.id')->join('users', 'compras.idusuario', '=', 'users.id')->join('detalle_compras', 'compras.id', '=', 'detalle_compras.idcompra')->select('compras.id', 'compras.idproveedor', 'compras.idusuario', 'compras.tipo_identificacion', 'compras.num_compra', 'compras.fecha_compra', 'compras.impuesto', 'compras.total', 'compras.estado', 'providers.nombre as proveedor', 'users.nombre')->where('compras.num_compra', 'LIKE', '%'.$sql.'%')->orderBy('compras.id', 'desc')->groupBy('compras.id', 'compras.tipo_identificacion', 'compras.num_compra', 'compras.fecha_compra', 'compras.impuesto', 'compras.estado', 'compras.total', 'compras.idproveedor', 'providers.nombre', 'compras.idusuario', 'users.nombre')->paginate(8);

   		return view('compra.index', [
   			'compras' => $compras,
   			'buscarTexto' => $sql
   		]);
		}
	}

	public function create(Request $request)
	{
		$proveedores = DB::table('providers')->get();

		$productos = DB::table('products as prod')->select(DB::raw('CONCAT(prod.codigo," ", prod.nombre) AS producto'), 'prod.id')->where('prod.condicion', '=', '1')->get();

		return view('compra.create', [
			'proveedores' => $proveedores,
			'productos' => $productos
		]);
	}

	public function store(Request $request)
	{
		try{
			DB::beginTransaction();

			$mytime = Carbon::now('America/Mexico_City');

			$compra = new Compra();
			$compra->idproveedor = $request->id_proveedor;
			$compra->idusuario = \Auth::user()->id;
			$compra->tipo_identificacion = $request->tipo_identificacion;
			$compra->num_compra = $request->num_compra;
			$compra->fecha_compra = $mytime->toDateString();
			$compra->impuesto = '0.20';
			$compra->total = $request->total_pagar;
			$compra->estado = 'Registrado';
			$compra->save();

			$id_producto = $request->id_producto;
			$cantidad = $request->cantidad;
			$precio = $request->precio_compra;

			$cont = 0;

			while($cont < count($id_producto))
			{
				$detalle = new DetalleCompra();
				//Enviamos los valores a las propiedades del objeto detalle
				//Al idcompra del objeto detalle le envio el id del objeto del objeto compra, que es el objeto que se ingresó en la tabla compras de la BD
				$detalle->idcompra = $compra->id;
				$detalle->idproducto = $id_producto[$cont];
				$detalle->cantidad = $cantidad[$cont];
				$detalle->precio = $precio[$cont];
				$detalle->save();
				$cont = $cont + 1;
			}

			DB::commit();
		}catch(Exception $e){

			DB::rollBack();

		}

		return Redirect::to('compra');
	}

	public function show($id)
	{
		$compra = Compra::join('providers', 'compras.idproveedor', '=', 'providers.id')->join('detalle_compras', 'compras.id', '=', 'detalle_compras.idcompra')->select('compras.id', 'compras.idproveedor', 'compras.idusuario', 'compras.tipo_identificacion', 'compras.num_compra', 'compras.fecha_compra', 'compras.impuesto', 'compras.estado', DB::raw('sum(detalle_compras.cantidad*precio) as total'), 'providers.nombre')->where('compras.id', '=', $id)->orderBy('compras.id', 'desc')->groupBy('compras.id', 'compras.idproveedor', 'compras.idusuario', 'compras.tipo_identificacion', 'compras.num_compra', 'compras.fecha_compra', 'compras.impuesto', 'compras.estado', 'providers.nombre')->first();

		$detalles = DetalleCompra::join('products', 'detalle_compras.idproducto', '=', 'products.id')->select('detalle_compras.cantidad', 'detalle_compras.precio', 'products.nombre as producto')->where('detalle_compras.idcompra', '=', $id)->orderBy('detalle_compras.id', 'desc')->get();

		return view('compra.show', [
			'compra' => $compra,
			'detalles' => $detalles
		]);
	}

	public function destroy(Request $request)
	{
		$compra = Compra::findOrFail($request->id_compra);
		$compra->estado = 'Anulado';
		$compra->save();
		return Redirect::to('compra');
	}

	public function pdf(Request $request, $id)
	{
		$compra = Compra::join('providers', 'compras.idproveedor', '=', 'providers.id')->join('users', 'compras.idusuario', '=', 'users.id')->join('detalle_compras', 'compras.id', '=', 'detalle_compras.idcompra')->select('compras.id', 'compras.tipo_identificacion', 'compras.num_compra', 'compras.impuesto', 'compras.estado', 'compras.created_at', DB::raw('sum(detalle_compras.cantidad*precio) as total'), 'providers.nombre', 'providers.tipo_documento', 'providers.num_documento', 'providers.direccion', 'providers.email', 'providers.telefono', 'providers.telefono', 'users.usuario')->where('compras.id', '=', $id)->orderBy('compras.id', 'desc')->groupBy('compras.id', 'compras.tipo_identificacion', 'compras.num_compra', 'compras.impuesto', 'compras.estado', 'compras.created_at', 'providers.nombre', 'providers.tipo_documento', 'providers.num_documento', 'providers.direccion', 'providers.email', 'providers.telefono', 'providers.telefono', 'users.usuario')->take(1)->get();

		$detalles = DetalleCompra::join('products', 'detalle_compras.idproducto', '=', 'products.id')->select('detalle_compras.cantidad', 'detalle_compras.precio', 'products.nombre as producto')->where('detalle_compras.idcompra', '=', $id)->orderBy('detalle_compras.id', 'desc')->get();

		$numcompra = Compra::select('num_compra')->where('id', $id)->get();

		$pdf = \PDF::loadView('pdf.compra', [
			'compra' => $compra,
			'detalles' => $detalles
		]);

		return $pdf->download('compra-'.$numcompra[0]->num_compra.'.pdf');
	}
}
