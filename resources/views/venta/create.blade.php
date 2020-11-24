@extends('principal')
@section('contenido')
<main class="main">
	<div class="card-body">
		<h2>Agergar Venta</h2>
		<span><strong>(*) Campo Obligatorio</strong></span>
		<h3 class="text-center">Llenar el formulario</h3>
		<form method="post" action="{{route('venta.store')}}">
			{{csrf_field()}}
			<div class="form-group row">
				<div class="col-md-8">
					<label class="form-control-label" for="nombre">Nombre del cliente</label>
					<select class="form-control selectpicker" name="id_cliente" id="id_cliente" data-live-search="true" required>
						<option disabled="" selected="">--Seleccione--</option>
						@foreach($clientes as $cliente)
						<option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-8">
					<label class="form-control-label" for="documento">Documento</label>
					<select class="form-control" name="tipo_identificacion" id="tipo_identificacion" required>
						<option disabled="" selected="">--Seleccione--</option>
						<option value="FACTURA">Factura</option>
						<option value="TICKER">Ticket</option>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-8">
					<label class="form-control-label" for="num_venta">Número Venta</label>
					<input type="text" name="num_venta" id="num_venta" class="form-control" placeholder="Ingrese el número venta" pattern="[0-9]{0,15}">
				</div>
			</div>

			<div class="form-group row border">
				<div class="col-md-8">
					<label class="form-control-label" for="nombre">Producto</label>
					<select class="form-control selectpicker" name="id_producto" id="id_producto" data-live-search="true" required>
						<option selected="" disabled="">--Seleccione--</option>
						@foreach($productos as $producto)
						<option value="{{$producto->id}}_{{$producto->stock}}_{{$producto->precio_venta}}">{{$producto->producto}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-2">
					<label class="form-control-label" for="cantidad">Cantidad</label>
					<input type="number" name="cantidad" id="cantidad" class="form-control" placeholder="Ingrese cantidad" pattern="[0-9]{0,15}">
				</div>

				<div class="col-md-2">
					<label class="form-control-label" for="stock">Stock</label>
					<input type="number" name="stock" id="stock" placeholder="Ingrese el stock" pattern="[0-9]{0,15}" disabled="">
				</div>

				<div class="col-md-2">
					<label class="form-control-label" for="precio_venta">Precio Venta</label>
					<input type="number" name="precio_venta" id="precio_venta" class="form-control" placeholder="Ingrese precio de venta" disabled="">
				</div>

				<div class="col-md-2">
					<label class="form-control-label" for="impuesto">Descuento</label>
					<input type="number" name="descuento" id="descuento" class="form-control" placeholder="Ingrese el documento">
				</div>

				<div class="col-md-4">
					<button type="button" id="agregar" class="btn btn-primary">
						<i class="fa fa-plus fa-2x"></i>Agregar detalle
					</button>
				</div>
			</div>

			<div class="form-group row border">
				<h3>Lista de Ventas a Clientes</h3>
				<div class="table-responsive col-md-12">
					<table id="detalles" class="table table-bordered table-striped table-sm">
						<thead>
							<tr class="bg-success">
								<th>Eliminar</th>
								<th>Producto</th>
								<th>Precio Venta(USD$)</th>
								<th>Descuento</th>
								<th>Cantidad</th>
								<th>Subtotal (USD$)</th>
							</tr>
						</thead>

						<tbody></tbody>

						<tfoot>
							<tr>
								<th colspan="5"><p align="right">TOTAL: </p></th>
								<th><p align="right"><span id="total">USD$ 0.00</span></p></th>
							</tr>

							<tr>
								<th colspan="5"><p align="right">TOTAL IMPUESTO (20%): </p></th>
								<th><p align="right"><span id="total_impuesto">USD$ 0.00</span></p></th>
							</tr>

							<tr>
								<th colspan="5"><p align="right">TOTAL PAGAR: </p></th>
								<th><p align="right"><span align="right" id="total_pagar_html">USD$ 0.00</span><input type="hidden" name="total_pagar" id="total_pagar"></p></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>

			<div class="modal-footer form-group	row" id="guardar">
				<div class="col-md">
					<input type="hidden" name="_toker" value="{{csrf_token()}}">

					<button type="submit" class="btn btn-success">
						<i class="fa fa-save fa-2x"></i>Registrar
					</button>
				</div>
			</div>
		</form>
	</div>
</main>
@push('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$("#agregar").click(function(){
			agregar();
		});
	});

	var cont = 0;
	total = 0;
	subtotal = [];
	$("#guardar").hide();
	$("#id_producto").change(mostrarValores);

	function mostrarValores(){
		datosProducto = document.getElementById('id_producto').value.split('_');

		$("#precio_venta").val(datosProducto[2]);
		$("#stock").val(datosProducto[1]);
	}

	function agregar(){
		datosProducto = document.getElementById('id_producto').value.split('_');

		id_producto = datosProducto[0];
		producto = $('#id_producto option:selected').text();
		cantidad = $('#cantidad').val();
		descuento = $('#descuento').val();
		precio_venta = $('#precio_venta').val();
		stock = $('#stock').val();
		impuesto = 20;

		if(id_producto != "" && cantidad != "" && cantidad > 0 && descuento != "" && precio_venta != ""){
			if(parseInt(stock) >= parseInt(cantidad)){
				subtotal[cont] = (cantidad*precio_venta)-(cantidad*precio_venta*descuento/100);
				total = total + subtotal[cont];

				var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onClick="eliminar('+cont+');"><i class="fa fa-times fa-2x"></i></button></td><td><input type="hidden" name="id_producto[]" value="'+id_producto+'">'+producto+'</td><td><input type="number" name="precio_venta[]" value="'+parseFloat(precio_venta).toFixed(2)+'"></td><td><input type="number" name="descuento[]" value="'+parseFloat(descuento).toFixed(2)+'"></td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td>$'+parseFloat(subtotal[cont].toFixed(2))+'</td></tr>';

				cont++;
				limpiar();
				totales();
				evaluar();
				$('#detalles').append(fila);
			}else{
				alert('La cantidad a vender supera el stock');
			}
		}else{
			alert('Rellene todos los campos del detalle de la venta');
		} 
	}

	function limpiar(){
		$('#cantidad').val("");
		$('#descuento').val("0");
		$('#precio_venta').val("");
	}

	function totales(){
		$('#total').html('USD$ ' + total.toFixed(2));

		total_impuesto = total*impuesto/100;
		total_pagar = total + total_impuesto;
		$('#total_impuesto').html('USD$' + total_impuesto.toFixed(2));
		$('#total_pagar_html').html('USD$ ' + total_pagar.toFixed(2));
		$('#total_pagar').val(total_pagar.toFixed(2));
	}

	function evaluar(){
		if(total > 0){
			$('#guardar').show();
		}else{
			$('#guardar').hide();
		}
	}

	function eliminar(index){
		total = total - subtotal[index];
		total_impuesto = total*20/100;
		total_pagar_html = total + total_impuesto;

		$('#total').html('USD$' + total);
		$('#total_impuesto').html('USD$' + total_impuesto);
		$('#total_pagar_html').html('USD$' + total_pagar_html);
		$('#total_pagar').val(total_pagar_html.toFixed(2));

		$('#fila' + index).remove();
		evaluar();
	}
</script>
@endpush
@endsection