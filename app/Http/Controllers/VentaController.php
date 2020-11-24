<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venta;
use App\DetalleVenta;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use DB;

class VentaController extends Controller
{
    public function index(Request $request){
    	if($request){
    		$sql = trim($request->get('buscarTexto'));

    		$ventas = Venta::join('customers', 'ventas.idcliente', '=', 'customers.id')->join('users', 'ventas.idusuario', '=', 'users.id')->join('detalle_ventas', 'ventas.id', '=', 'detalle_ventas.idventa')->select('ventas.id', 'ventas.tipo_identificacion', 'ventas.num_venta', 'ventas.fecha_venta', 'ventas.impuesto', 'ventas.total', 'ventas.estado', 'customers.nombre as cliente', 'users.nombre')->where('ventas.num_venta', 'LIKE', '%'.$sql.'%')->orderBy('ventas.id', 'desc')->groupBy('ventas.id', 'ventas.tipo_identificacion', 'ventas.num_venta', 'ventas.fecha_venta', 'ventas.impuesto', 'ventas.total', 'ventas.estado', 'customers.nombre', 'users.nombre')->paginate(8);

    		return view('venta.index', [
    			'ventas' => $ventas,
    			'buscarTexto' => $sql
    		]);
    	}
    }

    public function create(){
    	$clientes = DB::table('customers')->get();

    	$productos = DB::table('products as prod')->select(DB::raw('CONCAT(prod.codigo," ",prod.nombre) AS producto'), 'prod.id', 'prod.stock','prod.precio_venta')->where('prod.condicion', '=', '1')->where('prod.stock', '>', '0')->get();

    	return view('venta.create', [
    		'clientes' => $clientes,
    		'productos' => $productos
    	]);
    }

    public function store(Request $request){
    	try{
    		DB::beginTransaction();

    		$mytime = Carbon::now('America/Mexico_City');

    		$venta = new Venta();
    		$venta->idcliente = $request->id_cliente;
    		$venta->idusuario = \Auth::user()->id;
    		$venta->tipo_identificacion = $request->tipo_identificacion;
    		$venta->num_venta = $request->num_venta;
    		$venta->fecha_venta = $mytime->toDateString();
    		$venta->impuesto = '0.20';
    		$venta->total = $request->total_pagar;
    		$venta->estado = 'Registrado';
    		$venta->save();

    		$id_producto = $request->id_producto;
    		$cantidad = $request->cantidad;
    		$descuento = $request->descuento;
    		$precio = $request->precio_venta;

    		$cont = 0;

    		while($cont < count($id_producto)){
    			$detalle = new DetalleVenta();
    			$detalle->idventa = $venta->id;
    			$detalle->idproducto = $id_producto[$cont];
    			$detalle->cantidad = $cantidad[$cont];
    			$detalle->precio = $cantidad[$cont];
    			$detalle->descuento = $descuento[$cont];
    			$detalle->save();
    			$cont++;
    		}

    		DB::commit();
    	}catch(Exception $e){
    		DB::rollBack();
    	}

    	return Redirect::to('venta');
    }

    public function show($id){
    	$venta = Venta::join('customers', 'ventas.idcliente', '=', 'customers.id')->join('detalle_ventas', 'ventas.id', '=', 'detalle_ventas.idventa')->select('ventas.id', 'ventas.tipo_identificacion', 'ventas.num_venta', 'ventas.fecha_venta', 'ventas.impuesto', 'ventas.total', 'ventas.estado', 'customers.nombre', 'detalle_ventas.cantidad', 'detalle_ventas.precio', 'detalle_ventas.descuento', DB::raw('sum(detalle_ventas.cantidad*precio - detalle_ventas.cantidad*precio*descuento/100) as total'))->where('ventas.id', '=', $id)->orderBy('ventas.id', 'desc')->groupBy('ventas.id', 'ventas.tipo_identificacion', 'ventas.num_venta', 'ventas.fecha_venta', 'ventas.impuesto', 'ventas.total', 'ventas.estado', 'customers.nombre', 'detalle_ventas.cantidad', 'detalle_ventas.precio', 'detalle_ventas.descuento')->first();

    	$detalles = DetalleVenta::join('products', 'detalle_ventas.idproducto', '=', 'products.id')->select('detalle_ventas.cantidad', 'detalle_ventas.precio', 'detalle_ventas.descuento', 'products.nombre as producto')->where('detalle_ventas.idventa', '=', $id)->orderBy('detalle_ventas.id', 'desc')->get();

    	return view('venta.show', [
    		'venta' => $venta,
    		'detalles' => $detalles
    	]);
    }

    public function destroy(Request $request){
    	$venta = Venta::findOrFail($request->id_venta);
    	$venta->estado = 'Anulado';
    	$venta->save();

    	return Redirect::to('venta');
    }

    public function pdf(Request $request, $id){

    	$venta = Venta::join('customers', 'ventas.idcliente', '=', 'customers.id')->join('users', 'ventas.idusuario', '=', 'users.id')->join('detalle_ventas', 'ventas.id', '=', 'detalle_ventas.idventa')->select('ventas.id', 'ventas.tipo_identificacion', 'ventas.num_venta', 'ventas.created_at', 'ventas.impuesto', 'ventas.estado', DB::raw('sum(detalle_ventas.cantidad*precio - detalle_ventas.cantidad*precio*descuento/100) as total'), 'customers.nombre', 'customers.tipo_documento', 'customers.num_documento', 'customers.direccion', 'customers.email', 'customers.telefono', 'users.usuario')->where('ventas.id', '=', $id)->orderBy('ventas.id', 'desc')->groupBy('ventas.id', 'ventas.tipo_identificacion', 'ventas.num_venta', 'ventas.created_at', 'ventas.impuesto', 'ventas.estado', 'customers.nombre', 'customers.tipo_documento', 'customers.num_documento', 'customers.direccion', 'customers.email', 'customers.telefono', 'users.usuario')->take(1)->get();

    	$detalles = DetalleVenta::join('products', 'detalle_ventas.idproducto', '=', 'products.id')->select('detalle_ventas.cantidad', 'detalle_ventas.precio', 'detalle_ventas.descuento', 'products.nombre as producto')->where('detalle_ventas.idventa', '=', $id)->orderBy('detalle_ventas.id', 'desc')->get();

    	$numventa = Venta::select('num_venta')->where('id', $id)->get();

    	$pdf = \PDF::loadView('pdf.venta', [
    		'venta' => $venta,
    		'detalles' => $detalles
    	]);

    	return $pdf->download('venta-'.$numventa[0]->num_venta.'.pdf');
    }
}
