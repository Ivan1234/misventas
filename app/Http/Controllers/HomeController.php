<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $comprasmes = DB::select('SELECT monthname(c.fecha_compra) as mes, sum(c.total) as totalmes from compras c where c.estado = "Registrado" group by monthname(c.fecha_compra) order by month(c.fecha_compra) asc limit 12');
        $ventasmes = DB::select('SELECT monthname(v.fecha_venta) as mes, sum(v.total) as totalmes from ventas v where v.estado = "Registrado" group by monthname(v.fecha_venta) order by month(v.fecha_venta) asc limit 12');
        $totales = DB::select('SELECT(select ifnull(sum(c.total),0) from compras c where DATE(c.fecha_compra)=curdate() and c.estado="Registrado") as totalcompra, (select ifnull(sum(v.total),0) from ventas v where DATE(v.fecha_venta)=curdate() and v.estado="Registrado") as totalventa');

        return view('dashboard', [
            'comprasmes' => $comprasmes,
            'ventasmes' => $ventasmes,
            'totales' => $totales
        ]);
    }
}
