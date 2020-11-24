@extends('principal')
@section('contenido')
<main class="main">
	<div class="card-body">
		<h2 class="text-center">Detalle de Venta</h2>
		<div class="form-group row">
			<div class="col-md-4">
				<label class="form-control-label" for="nombre">Cliente</label>
				<p>{{$venta->nombre}}</p>
			</div>

			<div class="col-md-4">
				<label class="form-control-label" for="documento">Documento</label>
				<p>{{$venta->tipo_identificacion}}</p>
			</div>

			<div class="col-md-4">
				<label class="form-control-label" for="num_venta">Número Venta</label>
				<p>{{$venta->num_venta}}</p>
			</div>
		</div>

		<div class="form-group row border">
			<h3>Detalle de ventas</h3>
			<div class="table-responsive col-md-12">
				<table id="detalles" class="table table-bordered table-striped table-sm">
					<thead>
						<tr class="bg-success">
							<th>Producto</th>
							<th>Precio Venta (USD$)</th>
							<th>Descuento (USD$)</th>
							<th>Cantidad</th>
							<th>Subtotal (USD$)</th>
						</tr>
					</thead>

					<tbody>
						@foreach($detalles as $detalle)
						<tr>
							<td>{{$detalle->producto}}</td>
							<td>${{$detalle->precio}}</td>
							<td>{{$detalle->descuento}}</td>
							<td>{{$detalle->cantidad}}</td>
							<td>${{number_format($detalle->cantidad*$detalle->precio - $detalle->cantidad*$detalle->precio*$detalle->descuento/100, 2)}}</td>
						</tr>
						@endforeach
					</tbody>
					
					<tfoot>
						<tr>
							<th colspan="4"><p align="right">TOTAL: </p></th>
							<th><p align="right">${{number_format($venta->total, 2)}}</p></th>
						</tr>

						<tr>
							<th colspan="4"><p align="right">TOTAL IMPUESTO (20%): </p></th>
							<th><p align="right">${{number_format($venta->total*0.2, 2)}}</p></th>
						</tr>

						<tr>
							<th colspan="4"><p align="right">TOTAL PAGAR: </p></th>
							<th><p align="right">${{number_format($venta->total+($venta->total * 0.2), 2)}}</p></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</main>
@endsection