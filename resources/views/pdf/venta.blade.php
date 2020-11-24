<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale-1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Reporte de Venta</title>
	<style type="text/css">
		body {
        font-family: Arial, sans-serif; 
        font-size: 14px;
        }
 
 
        #datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        /*text-align: justify;*/
        }
 
        #encabezado{
        text-align: center;
        margin-left: 35%;
        margin-right: 35%;
        font-size: 15px;
        }
 
        #fact{
        /*position: relative;*/
        float: right;
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 20px;
        background:#D2691E;
        }
 
        section{
        clear: left;
        }
 
        #cliente{
        text-align: left;
        }
 
        #facliente{
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }
 
        #fac, #fv, #fa{
        color: #FFFFFF;
        font-size: 15px;
        }
 
        #facliente thead{
        padding: 20px;
        background:#D2691E;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;  
        }
 
        #facvendedor{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }
 
        #facvendedor thead{
        padding: 20px;
        background: #D2691E;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }
 
        #facproducto{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }
 
        #facproducto thead{
        padding: 20px;
        background: #D2691E;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        } 
	</style>
</head>
<body>
	@foreach($venta as $v)
	<header>
		<table id="datos">
			<thead>
				<tr>
					<th id="">DATOS DEL VENDEDOR</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th><p id="proveedor">Nombre: {{$v->nombre}}<br>{{$v->tipo_identificacion}}--Venta: {{$v->num_venta}}<br>
					Dirección: {{$v->direccion}} <br>
					Teléfono: {{$v->telefono}} <br>
					Email: {{$v->email}}</p></th>
				</tr>
			</tbody>
		</table>

		<div id="fact">
			<p>{{$v->tipo_identificacion}}--Venta <br>
				{{$v->num_venta}}</p>
		</div>
	</header>
	@endforeach

	<section>
		<table id="facproducto">
			<thead>
				<tr id="fa">
					<th>CANTIDAD</th>
					<th>PRODUCTO</th>
					<th>PRECIO_VENTA (USD$)</th>
					<th>DESCUENTO (%)</th>
					<th>SUBTOTAL (USD$)</th>
				</tr>
			</thead>
			<tbody>
				@foreach($detalles as $detalle)
				<tr>
					<td>{{$detalle->cantidad}}</td>
					<td>{{$detalle->producto}}</td>
					<td>{{$detalle->precio}}</td>
					<td>{{$detalle->descuento}}</td>
					<td>${{number_format($detalle->cantidad*$detalle->precio - $detalle->cantidad*$detalle->precio*$detalle->descuento/100,2)}}</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				@foreach($venta as $v)
				<tr>
					<th colspan="4"><p align="right">TOTAL: </p></th>
					<td><p align="right">${{number_format($v->total, 2)}}</p></td>
				</tr>

				<tr>
					<th colspan="4"><p align="right">TOTAL IMPUESTO (20%):</p></th>
					<td><p align="right">${{number_format($v->total*20/100, 2)}}</p></td>
				</tr>

				<tr>
					<th colspan="4"><p align="right">TOTAL PAGAR:</p></th>
					<td><p align="right">${{number_format($v->total+($v->total*20/100), 2)}}</p></td>
				</tr>
				@endforeach
			</tfoot>
		</table>
	</section>

	<footer>
		<div id="datos">
			<p id="encabezado">
				<b>icesoft.com</b> <br>Iván Ramírez <br>
				Teléfono: (+52)2227106025 <br>
				Email: iramirez@icesoft.com
			</p>
		</div>
	</footer>
</body>
</html>