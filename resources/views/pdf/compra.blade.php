<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewpoint" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Reporte de Compras</title>
	<style type="text/css">
		body{
			font-family: Arial, sans-serif;	
			font-size: 14px;
		}

		#datos{
			float: left;
			margin-top: 0%;
			margin-left: 2%;
			margin-right: 2%;
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
			background:#33AFFF;
		}

		section{
			clear: left;
		}

		#cliente{
			text-align: left;
		}

		#faproveedor{
			width: 40%;
			border-collapse: collapse;
			border-spacing: 0;
			margin-bottom: 15px;
		}

		#fac, #fv, #fa{
			color: #FFFFFF;
			font-size: 15px;
		}

		#faproveedor thead{
			padding: 20px;
			background:#33AFFF;
			text-align: left;
			border-bottom: 1px solid #FFFFFF;  
		}

		#faccomprador{
			width: 100%;
			border-collapse: collapse;
			border-spacing: 0;
			margin-bottom: 15px;
		}

		#faccomprador thead{
			padding: 20px;
			background: #33AFFF;
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
			background: #33AFFF;
			text-align: center;
			border-bottom: 1px solid #FFFFFF;  
		}
	</style>
</head>
<body>
	@foreach($compra as $v)
	<header>
		<table id="datos">
			<thead>
				<tr>
					<th>DATOS DEL PROVEEDOR</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><p id="proveedor">Nombre: {{$v->nombre}}<br>{{$v->tipo_identificacion}}--COMPRA: {{$v->num_compra}}<br>DIRECCION: {{$v->direccion}}<br>TELÉFONO: {{$v->telefono}}<br>EMAIL: {{$v->email}}</p></td>
				</tr>
			</tbody>
		</table>
		<div class="fact">
			<p>{{$v->tipo_identificacion}} COMPRA:<br>{{$v->num_compra}}</p>
		</div>
	</header>
	@endforeach

	<section>
		<table id="faccomprador">
			<thead>
				<tr id="fv">
					<th>COMPRADOR</th>
					<th>FECHA COMPRA</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{$v->usuario}}</td>
					<td>{{$v->created_at}}</td>
				</tr>
			</tbody>
		</table>
	</section>

	<section>
		<table id="facproducto">
			<thead>
				<tr id="fa">
					<th>CANTIDAD</th>
					<th>PRODUCTO</th>
					<th>PRECIO COMPRA (USD$)</th>
					<th>SUBTOTAL (USD$)</th>
				</tr>
			</thead>
			<tbody>
				@foreach($detalles as $detalle)
				<tr>
					<td>{{$detalle->cantidad}}</td>
					<td>{{$detalle->producto}}</td>
					<td>{{$detalle->precio}}</td>
					<td>${{number_format($detalle->cantidad*$detalle->precio, 2)}}</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				@foreach($compra as $c)
				<tr>
					<th colspan="3"><p align="right">TOTAL: </p></th>
					<td><p align="right">${{number_format($c->total)}}</p></td>
				</tr>
				<tr>
					<th colspan="3"><p align="right">TOTAL IMPUESTO (20%): </p></th>
					<td><p align="right">${{number_format($c->total*$c->impuesto)}}</p></td>
				</tr>
				<tr>
					<th  colspan="3"><p align="right">TOTAL PAGAR:</p></th>
					<td><p align="right">$ {{number_format($c->total+($c->total*$c->impuesto),2)}}</p></td>
				</tr>
				@endforeach
			</tfoot>
		</table>
	</section>

	<footer>
		<div id="datos">
			<p id="encabezado">
				<b>icesoft.com</b><br>Iván Ramírez<br>Teléfono: (+52)2227106025 <br>Email: iramirez@icesoft.com
			</p>
		</div>
	</footer>
</body>
</html>