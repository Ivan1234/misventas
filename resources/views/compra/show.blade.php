@extends('principal')

@section('contenido')
<main class="main">
	<div class="card-body">
		<h2 class="text-center">Detalle Compra</h2>
		<div class="form-group row">
			<div class="col-md-4">
				<label class="form-control-label" for="nombre">Proveedor</label>
				<p>{{$compra->nombre}}</p>
			</div>	
			<div class="col-md-4">
				<label class="form-control-label" for="documento">Documento</label>
				<p>{{$compra->tipo_identificacion}}</p>
			</div>			
			<div class="col-md-4">
				<label class="form-control-label" for="num_compra">Número de Compra</label>
				<p>{{$compra->num_compra}}</p>
			</div>
		</div>

		<div class="form-group row boder">
			<h3>Detalle de Compras</h3>
			<div class="table-responsive col-md-12">
				<table class="table table-bordered table-striped table-sm" id="detalles">
					<thead>
						<tr class="bg-success">
							<th>Producto</th>
							<th>Precio(USD$)</th>
							<th>Cantidad</th>
							<th>Subtotal(USD$)</th>
						</tr>
					</thead>

					<tbody>
						@foreach($detalles as $detalle)
						<tr>
							<td>{{$detalle->producto}}</td>
							<td>${{$detalle->precio}}</td>
							<td>{{$detalle->cantidad}}</td>
							<td>${{number_format($detalle->cantidad*$detalle->precio, 2)}}</td>
						</tr>
						@endforeach
					</tbody>

					<tfoot>
						<tr>
							<th colspan="3"><p align="right">TOTAL: </p></th>							
							<th><p align="right">${{number_format($compra->total, 2)}}</p></th>
						</tr>
							<th colspan="3"><p align="right">TOTAL IMPUESTO (20%): </p></th>
							<th><p align="right">${{number_format($compra->total*(20/100), 2)}}</p></th>
						<tr>
							<th colspan="3"> <p align="right">TOTAL A PAGAR: S</p></th>
							<th><p align="right">${{number_format($compra->total+($compra->total * 20/100),2)}}</p></th>
						</tr>

						<tr>
							
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</main>
@endsection