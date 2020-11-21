@extends('principal')

@section('contenido')
<main class="main">
    <div class="card-body">
        <h2>Agregar Compra</h2>
        <span><strong>(*) Campos Obligatorios</strong></span>
        <h3 class="text-center">Llenar el formulario</h3>
        <form method="post" action="{{route('compra.store')}}">
            {{csrf_field()}}
            <div class="form-group row">
                <div class="col-md-8">
                    <label class="form-control-label" for="nombre">Nombre del Proveedor</label>
                    <select class="form-control selectpicker" name="id_proveedor" id="id_proveedor" data-live-search="true">
                        <option selected="" disabled="">--Seleccione un proveedor--</option>
                        @foreach($proveedores as $proveedor)
                        <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                        @endforeach
                    </select>
                </div>          
            </div>

            <div class="form-group row">
                <div class="col-md-8">
                    <label class="form-control-label" for="documento">Documento</label>
                    <select class="form-control" name="tipo_identificacion" id="tipo_identificacion" required="">
                        <option selected="" disabled="">--Seleccione un tipo de identificación--</option>
                        <option value="DNI">DNI</option>
                        <option value="FACTURA">FACTURA</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-8">
                    <label class="form-control-label" for="num_compra">Número de compra</label>
                    <input type="text" name="num_compra" id="num_compra" class="form-control" placeholder="Ingrese el número de compra" required pattern="[0-9]{0,15}">
                </div>  
            </div>

            <div class="form-group row">
                <div class="col-md-8">
                    <label class="form-control-label" for="producto">Producto</label>
                    <select class="form-control" name="id_producto" id="id_producto">
                        <option selected="" disabled="">--Seleccione un producto--</option>
                        @foreach($productos as $producto)
                        <option value="{{$producto->id}}">{{$producto->producto}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-3">
                    <label class="form-control-label" for="cantidad">Cantidad</label>
                    <input type="number" name="cantidad" id=cantidad class="form-control" placeholder="Ingrese la cantidad" pattern="[0-9]{0,15}">
                </div>
                <div class="col-md-3">
                    <label class="form-control-label" for="precio">Precio</label>
                    <input type="number" name="precio" id="precio_compra" class="form-control" placeholder="Ingresa el precio" pattern="[0-9]{0,15}">
                </div>
                <div class="col-md-3">
                    <button type="button" id="agregar" class="btn btn-primary">
                        <i class="fa fa-plus fa-2x"></i> Agregar Detalle
                    </button>
                </div>
            </div>

            <div class="form-group row">
                <h3>Lista de compras a proveedores</h3>
                <div class="table-responsive col-md-12"></div>
                <table id="detalles" class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr class="bg-success">
                            <th>Eliminar</th>
                            <th>Producto</th>
                            <th>Precio(USD$)</th>
                            <th>Cantidad</th>
                            <th>SubTotal(USD$)</th>
                        </tr>                       
                    </thead>

                    <tfoot>
                        <tr>
                            <th colspan="4"><p align="right">TOTAL: </p></th>
                            <th><p align="right"><span id="total">USD$ 0.00</span></p></th>                         
                        </tr>
                        <tr>
                            <th colspan="4"><p align="right">TOTAL IMPUESTO (20%): </p></th>
                            <th><p align="right"><span id="total_impuesto">USD$ 0.00</span></p></th>    
                        </tr>
                        <tr>
                            <th colspan="4"><p align="right">TOTAL PAGAR: </p></th> 
                            <th><p align="right"><span align="right" id="total_pagar_html">USD$ 0.00</span><input type="hidden" name="total_pagar" id="total_pagar"></p></th>                       
                        </tr>           
                    </tfoot>

                    <tbody>
                        
                    </tbody>
                </table>
            </div>

            <div class="modal-footer form-group row" id="guardar">
                <div class="col-md">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save fa-2x"></i> Registrar
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

    function agregar(){
        id_producto = $("#id_producto").val();
        producto = $("#id_producto option:selected").text();
        cantidad = $("#cantidad").val();
        precio_compra = $("#precio_compra").val();
        impuesto = 20;

        if(id_producto != "" || cantidad != "" || cantidad > 0 || precio_compra != ""){
            subtotal[cont] = cantidad * precio_compra;
            total = total + subtotal[cont];

            var fila = '<tr class="selected" id="fila'+cont+'"><td><button class="btn btn-danger btn-sm" onclick="eliminar('+cont+');"><i class="fa fa-times fa-2x"></i></button></td><td><input type="hidden" name="id_producto[]" value="'+id_producto+'">'+producto+'</td><td><input type="number" id="precio_compra[]" name="precio_compra[]" value="'+precio_compra+'"></td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td>$'+subtotal[cont]+'</td></tr>';

            cont++;
            limpiar();
            totales();
            evaluar();

            $("#detalles").append(fila);
        }else{
            alert('Error');
        }
    }

    function limpiar(){
        $("#cantidad").val("");
        $("#precio_compra").val("");
    }

    function totales(){
        $("#total").html("USD$ " + total.toFixed(2));
        total_impuesto = total * (impuesto/100);
        total_pagar = total + total_impuesto;
        $("#total_impuesto").html("USD$ " + total_impuesto.toFixed(2));
        $("#total_pagar_html").html("USD$ " + total_pagar.toFixed(2));
        $("#total_pagar").val(total_pagar.toFixed(2));
    }

    function evaluar(){
        if(total>0){
            $("#guardar").show();
        }else{
            $("#guardar").hide();
        }
    }

    function eliminar(index){
        total = total - subtotal[index];
        total_impuesto = total * (20/100);
        total_pagar_html = total + total_impuesto;

        $("#total").html("USD$" + total);
        $("#total_impuesto").html("USD$" + total_impuesto);
        $("#total_pagar_html").html("USD$" + total_pagar_html);
        $("#total_pagar").html(total_pagar.toFixed(2));
        $("#fila" + index).remove();
        evaluar();
    }

    
</script>
@endpush
@endsection




