<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Compras-Ventas con Laravel y Vue Js- webtraining-it.com">
    <meta name="keyword" content="Sistema Compras-Ventas con Laravel y Vue Js">
    <title>Proyecto</title>
    <!-- Icons -->
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/simple-line-icons.min.css')}}" rel="stylesheet">
    <!-- Main styles for this application -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
<header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!--PONER LOGO-->
        <!--<a class="navbar-brand" href="#"></a>-->
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Dashbord</a>
            </li>
           
        </ul>
        <ul class="nav navbar-nav ml-auto">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="{{asset('storage/img/usuario/'.Auth::user()->imagen)}}" class="img-avatar" alt="admin@bootstrapmaster.com">
                    <span class="d-md-down-none">{{Auth::user()->usuario}} </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Cuenta</strong>
                    </div>
                    <a class="dropdown-item" href="{{route('logout')}}" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i> Cerrar sesión</a>

                    <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                        {{csrf_field()}}
                    </form>
                </div>
            </li>
        </ul>
    </header>

    <div class="app-body">
        
        @if(Auth::check())
            @if(Auth::user()->idrol == 1)
                @include('plantilla.sidebaradministrador')
            @elseif(Auth::user()->idrol == 2)    
                @include('plantilla.sidebarvendedor')
            @elseif(Auth::user()->idrol == 3)
                @include('plantilla.sidebarcomprador')
            @endif
        @endif
      
        <!-- Contenido Principal -->
           
           @yield('contenido')

        <!-- /Fin del contenido principal -->
    </div>   

    <footer class="app-footer">
        <span>Todos los derechos reservados &copy; 2019</span>
    </footer>

    <!-- Bootstrap and necessary plugins -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    @stack('scripts')
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/pace.min.js')}}"></script>
    <!-- Plugins and scripts required by all views -->
    <script src="{{asset('js/Chart.min.js')}}"></script>
    <!-- GenesisUI main scripts -->
    <script src="{{asset('js/template.js')}}"></script>

    <script>
    
         /*EDITAR CATEGORIA EN VENTANA MODAL*/
         $('#abrirmodalEditar').on('show.bs.modal', function (event) {
        
        //console.log('modal abierto');
        
        var button = $(event.relatedTarget) 
        var nombre_modal_editar = button.data('nombre')
        var descripcion_modal_editar = button.data('descripcion')
        var id_categoria = button.data('id_categoria')
        var modal = $(this)
        // modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body #nombre').val(nombre_modal_editar);
        modal.find('.modal-body #descripcion').val(descripcion_modal_editar);
        modal.find('.modal-body #id_categoria').val(id_categoria);
        })
        /*Fin de editar categoria en ventana modal*/
    
        /*
        *Inicio ventana modal para cambiar estado de categoría
        *
        */
        $('#cambiarEstado').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id_categoria = button.data('id_categoria')
            var modal = $(this)

            modal.find('.modal-body #id_categoria').val(id_categoria);
        })
        /*Fin de ventana modal para cambiar estado de categoría*/

        /*
        *EDITAR PRODUCTO EN VENTANA MODAL
        *
        */
        $('#abrirmodalEditar').on('show.bs.modal', function(event){
            /*El button.data es lo que está en el button editar*/
            var button = $(event.relatedTarget);
            /*Este id_categoria_modal_editar selecciona la categoria*/
            var id_categoria_modal_editar = button.data('id_categoria');
            var nombre_modal_editar = button.data('nombre');
            var precio_venta_modal_editar = button.data('precio_venta');
            var codigo_modal_editar = button.data('codigo');
            var stock_modal_editar = button.data('stock');
            var id_producto = button.data('id_producto');

            var modal = $(this);
            modal.find('.modal-body #id').val(id_categoria_modal_editar);
            modal.find('.modal-body #nombre').val(nombre_modal_editar);
            modal.find('.modal-body #precio_venta').val(precio_venta_modal_editar);
            modal.find('.modal-body #codigo').val(codigo_modal_editar);
            modal.find('.modal-body #stock').val(stock_modal_editar);
            modal.find('.modal-body #id_producto').val(id_producto);

        });
        /*Fin de EDITAR PRODUCTO EN VENTANA MODAL*/

        /*
        *Inicio de la ventana modal para la activación/desactivación del producto 
        *
        */
        $('#cambiarEstado').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);

            var id_producto_modal_eliminar = button.data('id_producto');

            var modal = $(this);
            modal.find('.modal-body #id_producto').val(id_producto_modal_eliminar);
        });
        /*Fin de ACTIVAR/DESACTIVAR PRODUCTO EN VENTANA MODAL*/

        /*EDITAR PROVEEDOR EN VENTANA MODAL*/
        $('#abrirmodalEditar').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);

            var id_proveedor_editar = button.data('id_proveedor');
            var nombre_editar = button.data('nombre');
            var tipo_documento_editar = button.data('tipo_documento');
            var num_documento_editar = button.data('num_documento');
            var telefono_editar = button.data('telefono');
            var email_editar = button.data('email');
            var direccion_editar = button.data('direccion');

            var modal = $(this);
            modal.find('.modal-body #id_proveedor').val(id_proveedor_editar);
            modal.find('.modal-body #nombre').val(nombre_editar);
            modal.find('.modal-body #direccion').val(direccion_editar);
            modal.find('.modal-body #tipo_documento').val(tipo_documento_editar);
            modal.find('.modal-body #num_documento').val(num_documento_editar);
            modal.find('.modal-body #telefono').val(telefono_editar);
            modal.find('.modal-body #email').val(email_editar);
        });

        /*FIN DE EDITAR PROVEEDOR EN VENTANA MODAL*/

         /*EDITAR CLIENTE EN VENTANA MODAL*/
        $('#abrirmodalEditar').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);

            var id_cliente_editar = button.data('id_cliente');
            var nombre_editar = button.data('nombre');
            var tipo_documento_editar = button.data('tipo_documento');
            var num_documento_editar = button.data('num_documento');
            var telefono_editar = button.data('telefono');
            var email_editar = button.data('email');
            var direccion_editar = button.data('direccion');

            var modal = $(this);
            modal.find('.modal-body #id_cliente').val(id_cliente_editar);
            modal.find('.modal-body #nombre').val(nombre_editar);
            modal.find('.modal-body #direccion').val(direccion_editar);
            modal.find('.modal-body #tipo_documento').val(tipo_documento_editar);
            modal.find('.modal-body #num_documento').val(num_documento_editar);
            modal.find('.modal-body #telefono').val(telefono_editar);
            modal.find('.modal-body #email').val(email_editar);
        });

        /*FIN DE EDITAR CLIENTE EN VENTANA MODAL*/

        /*EDITAR USUARIO EN VENTANA MODAL*/
        $('#abrirmodalEditar').on('show.bs.modal', function(event){

            var button = $(event.relatedTarget);

            var id_modal_editar = button.data('id_usuario');
            var nombre_modal_editar = button.data('nombre');
            var tipo_documento_modal_editar = button.data('tipo_documento');
            var num_documento_modal_editar = button.data('num_documento');
            var direccion_modal_editar = button.data('direccion');
            var telefono_modal_editar = button.data('telefono');
            var email_modal_editar = button.data('email');
            var usuario_modal_editar = button.data('usuario');
            var id_rol_modal_editar = button.data('id_rol');

            var modal = $(this);
        /*FIN DE EDITAR USUARIO EN VENTANA MODAL*/

            modal.find('.modal-body #nombre').val(nombre_modal_editar);
            modal.find('.modal-body #direccion').val(direccion_modal_editar);
            modal.find('.modal-body #num_documento').val(num_documento_modal_editar);
            modal.find('.modal-body #telefono').val(telefono_modal_editar);
            modal.find('.modal-body #email').val(email_modal_editar);            
            modal.find('.modal-body #usuario').val(usuario_modal_editar);
            modal.find('.modal-body #email').val(email_modal_editar);
            modal.find('.modal-body #id_usuario').val(id_modal_editar);
        });

        /*CAMBIAR ESTADO DE USUARIO EN VENTANA MODAL*/
        $('#cambiarEstado').on('show.bs.modal', function(event){

            var button = $(event. relatedTarget);

            var id_usuario_modal_editar = button.data('id_usuario');
            var modal = $(this);

            modal.find('.modal-body #id_usuario').val(id_usuario_modal_editar);
        });

        /*FIN DE CAMBIAR ESTADO DE USUARIO EN VENTANA MODAL*/

        /*INICIO DE CAMBIO DE ESTADO DE LA COMPRA EN VENTANA MODAL*/
        $('#cambiarEstadoCompra').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);

            var id_cambiar_estado_model = button.data('id_compra');
            var modal = $(this);

            modal.find('.modal-body #id_compra').val(id_cambiar_estado_model);
        });
        /*FIN DE CAMBIO DE ESTADO DE LA COMPRA EN VENTANA MODAL*/
    
    </script>


</body>

</html>