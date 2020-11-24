@extends('principal')

@section('contenido')
<main class="main">
	<ol class="breadcrumb">
		<li class="breadcrumb-item active"><a href="/">BACKEND-SISTEMA DE COMPRAS-VENTAS</a></li>
	</ol>
	<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<h2>Listado de Ventas</h2>
				<a href="venta/create">
					<button class="btn btn-primary btn-lg" type="button">
						<i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Venta
					</button>
				</a>
			</div>

			<div class="card-body">
				<div class="form-group row">
					<div class="col-md-6">
						<form method="get" action="{{route('venta.index')}}">
							<div class="input-group">
								<input type="text" name="buscarTexto" class="form-control" placeholder="Buscar Texto" value="{{$buscarTexto}}">
								<button class="btn btn-primary" type="submit">
									<i class="fa fa-search"></i>Buscar
								</button>
							</div>
						</form>
					</div>
				</div>

				<table class="table table-bordered table-striped table-sm">
					<thead>
						<tr class="bg-family">
							<th>Ver Detalles</th>
							<th>Fecha Venta</th>
							<th>Número Venta</th>
							<th>Cliente</th>
							<th>Tipo de Identificación</th>
							<th>Vendedor</th>
							<th>Total(USD$)</th>
							<th>Impuesto</th>
							<th>Estado</th>
							<th>Cambiar Estado</th>
							<th>Descargar Reporte</th>
						</tr>
					</thead>
					<tbody>
						@foreach($ventas as $venta)
						<tr>
							<td>
								<a href="{{URL::action('VentaController@show', $venta->id)}}">
									<button type="button" class="btn btn-warning btn-md">
										<i class="fa fa-eye fa-2x"></i>Ver detalle
									</button>&nbsp;
								</a>
							</td>
							<td>{{$venta->fecha_venta}}</td>
							<td>{{$venta->num_venta}}</td>
							<td>{{$venta->cliente}}</td>
							<td>{{$venta->tipo_identificacion}}</td>
							<td>{{$venta->nombre}}</td>
							<td>${{number_format($venta->total, 2)}}</td>
							<td>{{$venta->impuesto}}</td>
							<td>
								@if($venta->estado == "Registrado")
								<button type="button" class="btn btn-success btn-md">
									<i class="fa fa-check fa-2x"></i>Registrado
								</button>
								@else
								<button type="button" class="btn btn-danger btn-md">
									<i class="fa fa-check fa-2x"></i>Anulado
								</button>
								@endif
							</td>
							<td>
								@if($venta->estado == "Registrado")
								<button type="button" class="btn btn-danger btn-sm" data-id_venta="{{$venta->id}}" data-toggle="modal" data-target="#cambiarEstadoVenta">
									<i class="fa fa-times fa-2x"></i>Anular Venta		
								</button>
								@else
								<button type="button" class="btn btn-success btn-sm">
									<i class="fa fa-lock fa-2x"></i>Anulado
								</button>
								@endif
							</td>
							<td>
								<a href="{{url('pdfVenta', $venta->id)}}" target="_blanck">
									<button type="button" class="btn btn-info btn-sm">
										<i class="fa fa-file fa-2x"></i>Descargar pdf
									</button>&nbsp;
								</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				{{$ventas->render()}}
			</div>
		</div>
	</div>

	<div class="modal fade" id="cambiarEstadoVenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-danger" role="documento">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Cambiar Estado de Venta</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>

				<div class="modal-body">
					<form method="post" action="{{route('venta.destroy', 'test')}}">
						{{method_field('delete')}}
						{{csrf_field()}}
						<input type="hidden" name="id_venta" id="id_venta" value="">
						<p>¿Estas seguro de cambiar el estado?</p>
						<div class="modal-footer">
							<button class="btn btn-danger" type="button" data-dismiss="modal">
								<i class="fa fa-times fa-2x"></i>Cerrar
							</button>
							<button type="submit" class="btn btn-success">
								<i class="fa fa-lock fa-2x"></i>Aceptar
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div> 	
</main>
@endsection