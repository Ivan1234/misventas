<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{url('home')}}" onclick="event.preventDefault(); document.getElementById('home-form').submit();"><i class="fa fa-list"></i> Dashboard</a>
                <form id="home-form" action="{{url('home')}}" method="get" style="display:none;">
                    {{csrf_field()}}
                </form>
            </li>
            <li class="nav-title">
                Menú
            </li>


            <li class="nav-item">
                <a class="nav-link" href="{{url('categoria')}}" onclick="event.preventDefault(); document.getElementById('categoria-form').submit();"><i class="fa fa-list"></i> Categorías</a>
                <form id="categoria-form" action="{{url('categoria')}}" method="get" style="display:none;">
                    {{csrf_field()}}
                </form>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{url('producto')}}" onclick="event.preventDefault(); document.getElementById('producto-form').submit();"><i class="fa fa-list"></i> Productos</a>
                <form id="producto-form" action="{{url('producto')}}" method="get" style="display:none;">
                    {{csrf_field()}}
                </form>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{url('venta')}}" onclick="event.preventDefault(); document.getElementById('venta-form').submit();"><i class="fa fa-list"></i> Ventas</a>
                <form id="venta-form" action="{{url('venta')}}" method="get" style="display:none;">
                    {{csrf_field()}}
                </form>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{url('cliente')}}" onclick="event.preventDefault(); document.getElementById('cliente-form').submit();"><i class="fa fa-list"></i> Clientes</a>
                <form id="cliente-form" action="{{url('cliente')}}" method="get" style="display:none;">
                    {{csrf_field()}}
                </form>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
