 <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <base href="{{ url('/') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app-red.css" rel="stylesheet">
    <link href="/css/vendor.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>
    </script>
</head>

<body>
<div class="main-wrapper">
    <div class="app" id="app">
        <header class="header">
            <div class="header-block header-block-collapse hidden-lg-up">
                <button class="collapse-btn" id="sidebar-collapse-btn">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <!-- Search -->
            @yield('search')

            <div class="header-block header-block-buttons">

                <!-- Action buttons -->
                @yield('action-buttons')

            </div>
            <div class="header-block header-block-nav">
                <ul class="nav-profile">
                    <li class="profile dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            <span class="name">{{ auth()->user()->name }}</span> </a>
                        <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('/logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off icon"></i> Cerrar sesión
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
        <aside class="sidebar">
            <div class="sidebar-container">
                <div class="sidebar-header">
                    <div class="brand">
                        <img class="logo" src="img/logo.png" title="BH Developers" alt="BHD Logo">
                    </div>
                </div>
                <nav class="menu">
                    <ul class="nav metismenu" id="sidebar-menu">
                        <li {{ (Request::is('/') ? 'class=active' : '') }}>
                            <a href="{{ url('/') }}"> <i class="fa fa-home"></i> Inicio </a>
                        </li>
                        @role('admin')
                        <li class="{{ (Request::is('admin/users') ||
                                       Request::is('admin/users/new') ||
                                       Request::is('admin/users/edit/*') ||
                                       Request::is('admin/users/delete/*') ? 'active open' : '') }}">
                            <a href="">
                                <i class="fa fa-cubes"></i> Administrar <i class="fa arrow"></i>
                            </a>
                            <ul class="collapse {{ (Request::is('admin/users') ||
                                                    Request::is('admin/users/new') ||
                                                    Request::is('admin/users/edit/*') ||
                                                    Request::is('admin/users/delete/*') ? 'in' : '') }}">
                                <li {{ (Request::is('admin/users') ||
                                        Request::is('admin/users/new') ||
                                        Request::is('admin/users/edit/*') ||
                                        Request::is('admin/users/delete/*') ? 'class=active' : '') }}>
                                    <a href="{{ url('/admin/users') }}">
                                        Usuarios
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endrole
                        <li class="{{ (Request::is('product/reports/cash/*') ||
                                       Request::is('product/reports/sales/*') ||
                                       Request::is('product/reports/accounts-receivables') ||
                                       Request::is('product/reports/category-products') ||
                                       Request::is('product/reports/provider-products') ||
                                       Request::is('product/reports/merchandise-income-day') ? 'active open' : '') }}">
                            <a href="">
                                <i class="fa fa-line-chart"></i> Reportes <i class="fa arrow"></i>
                            </a>
                            <ul class="collapse {{ (Request::is('product/reports/cash/*') ||
                                                   Request::is('product/reports/discount/*') ||
                                                   Request::is('product/reports/sales/*') ||
                                                   Request::is('product/reports/accounts-receivables/*') ? 'in' : '') }}">
                        @role('admin')
                                <li {{ (Request::is('product/reports/cash/day') ? 'class=active' : '') }}>
                                    <a href="{{ url('/product/reports/cash/day') }}">
                                        Efectivo por Día
                                    </a>
                                </li>
                                <li {{ (Request::is('product/reports/discount/day') ? 'class=active' : '') }}>
                                    <a href="{{ url('/product/reports/discount/day') }}">
                                        Descuentos por Día
                                    </a>
                                </li>
                                <li {{ (Request::is('product/reports/cash/month') ? 'class=active' : '') }}>
                                    <a href="{{ url('/product/reports/cash/month') }}">
                                        Efectivo por Mes
                                    </a>
                                </li>
                        @endrole
                        @role('admin|user')
                                <li {{ (Request::is('product/reports/sales/day') ? 'class=active' : '') }}>
                                    <a href="{{ url('/product/reports/sales/day') }}">
                                        Ventas por Día
                                    </a>
                                </li>
                        @endrole
                        @role('admin')
                                <li {{ (Request::is('product/reports/sales/user/day') ? 'class=active' : '') }}>
                                    <a href="{{ url('/product/reports/sales/user/day') }}">
                                        Ventas Usuario por Día
                                    </a>
                                </li>
                                <li {{ (Request::is('product/reports/sales/user/month/*') ? 'class=active' : '') }}>
                                    <a href="{{ url('/product/reports/sales/user/month') }}">
                                        Ventas Usuario por Mes
                                    </a>
                                </li>
                                <li {{ (Request::is('product/reports/accounts-receivables') ? 'class=active' : '') }}>
                                    <a href="{{ url('/product/reports/accounts-receivables') }}">
                                        Cuentas por cobrar
                                    </a>
                                </li>
                                <li {{ (Request::is('product/reports/provider-products') ? 'class=active' : '') }}>
                                    <a href="{{ url('/product/reports/provider-products') }}">
                                        Productos por Proveedor
                                    </a>
                                </li>
                                <li {{ (Request::is('product/reports/category-products') ? 'class=active' : '') }}>
                                    <a href="{{ url('/product/reports/category-products') }}">
                                        Productos por Categoría
                                    </a>
                                </li>
                                <li {{ (Request::is('product/reports/merchandise-income-day') ? 'class=active' : '') }}>
                                    <a href="{{ url('product/reports/merchandise-income-day') }}">
                                        Ingreso de Mercaderia por Día
                                    </a>
                                </li>
                        @endrole
                            </ul>
                        </li>
                        @role('admin')
                        <li {{ (Request::is('product/providers') ||
                                Request::is('product/providers/new') ||
                                Request::is('product/providers/edit/*') ||
                                Request::is('product/providers/delete/*') ? 'class=active' : '') }}>
                            <a href="{{ url('product/providers') }}"> <i class="fa fa-truck"></i> Proveedores</a>
                        </li>
                        <li {{ (Request::is('product/store-cash') ? 'class=active' : '') }}>
                            <a href="{{ url('product/store-cash') }}"> <i class="fa fa-dollar"></i> Efectivo Tienda</a>
                        </li>
                        <li {{ (Request::is('product/categories') ||
                                Request::is('product/categories/new') ||
                                Request::is('product/categories/edit/*') ||
                                Request::is('product/categories/delete/*') ? 'class=active' : '') }}>
                            <a href="{{ url('product/categories') }}"> <i class="fa fa-tags"></i> Categorias</a>
                        </li>
                        <li {{ (Request::is('product/clients') ||
                                Request::is('product/clients/new') ||
                                Request::is('product/clients/edit/*') ||
                                Request::is('product/clients/delete/*') ? 'class=active' : '') }}>
                            <a href="{{ url('product/clients') }}"> <i class="fa fa-users"></i> Clientes</a>
                        </li>
                        <li {{ (Request::is('product/products') ||
                                Request::is('product/products/new') ||
                                Request::is('product/products/edit/*') ||
                                Request::is('product/products/delete/*') ? 'class=active' : '') }}>
                            <a href="{{ url('product/products') }}"> <i class="fa fa-shopping-cart"></i> Productos</a>
                        </li>
                        <li {{ (Request::is('product/documents-cash') ||
                                Request::is('product/documents-cash/new') ? 'class=active' : '') }}>
                            <a href="{{ url('product/documents-cash') }}"> <i class="fa fa-file-text"></i> Documentos Efectivo</a>
                        </li>
                        <li {{ (Request::is('product/movements-cash') ||
                                Request::is('product/movements-cash/new') ? 'class=active' : '') }}>
                            <a href="{{ url('product/movements-cash') }}"> <i class="fa fa-file-text"></i> Movimientos Efectivo</a>
                        </li>
                    <!--<li {{ (Request::is('product/costs') ||
                                Request::is('product/costs/new') ||
                                Request::is('product/costs/edit/*') ||
                                Request::is('product/costs/delete/*') ? 'class=active' : '') }}>
                            <a href="{{ url('product/costs') }}"> <i class="fa fa-money"></i> Costos</a>
                        </li>-->
                    <!--<li {{ (Request::is('product/inventories') ||
                                Request::is('product/inventories/new') ||
                                Request::is('product/inventories/edit/*') ||
                                Request::is('product/inventories/delete/*') ? 'class=active' : '') }}>
                            <a href="{{ url('product/inventories') }}"> <i class="fa fa-indent"></i> Inventario</a>
                        </li>-->
                    <!--<li {{ (Request::is('product/credit-types') ||
                                Request::is('product/credit-types/new') ||
                                Request::is('product/credit-types/edit/*') ||
                                Request::is('product/credit-types/delete/*') ? 'class=active' : '') }}>
                            <a href="{{ url('product/credit-types') }}"> <i class="fa fa-exchange"></i> Tipos de Credito</a>
                        </li>
                        <li {{ (Request::is('product/payment-methods') ||
                                Request::is('product/payment-methods/new') ||
                                Request::is('product/payment-methods/edit/*') ||
                                Request::is('product/payment-methods/delete/*') ? 'class=active' : '') }}>
                            <a href="{{ url('product/payment-methods') }}"> <i class="fa fa-credit-card"></i> Medios de pago</a>
                        </li>--->
                        @endrole
                        @role('admin')
                        <li {{ (Request::is('product/accounts-receivables') ||
                                Request::is('product/accounts-receivables/new') ||
                                Request::is('product/accounts-receivables/edit/*') ||
                                Request::is('product/accounts-receivables/delete/*') ? 'class=active' : '') }}>
                            <a href="{{ url('product/accounts-receivables') }}"> <i class="fa fa-money"></i> Cuentas por Cobrar</a>
                        </li>
                        <li {{ (Request::is('product/debts') ||
                                Request::is('product/debts/new') ||
                                Request::is('product/debts/edit/*') ||
                                Request::is('product/debts/delete/*') ? 'class=active' : '') }}>
                            <a href="{{ url('product/debts') }}"> <i class="fa fa-money"></i> Cuentas por pagar</a>
                        </li>
                    <!--<li {{ (Request::is('product/invoice-details') ||
                                Request::is('product/invoice-details/new') ||
                                Request::is('product/invoice-details/edit/*') ||
                                Request::is('product/invoice-details/delete/*') ? 'class=active' : '') }}>
                            <a href="{{ url('product/invoice-details') }}"> <i class="fa fa-dedent"></i> Detalles Factura</a>
                        </li>-->
                        @endrole
                        <li {{ (Request::is('product/invoices') ||
                                Request::is('product/invoices/new') ||
                                Request::is('product/invoices/edit/*') ||
                                Request::is('product/invoices/delete/*') ? 'class=active' : '') }}>
                            <a href="{{ url('product/invoices') }}"> <i class="fa fa-list-alt"></i> Venta de Mercaderia</a>
                        </li>
                        <li {{ (Request::is('product/quotations') ||
                                Request::is('product/quotations/new') ||
                                Request::is('product/quotations/edit/*') ||
                                Request::is('product/quotations/delete/*') ? 'class=active' : '') }}>
                            <a href="{{ url('product/quotations') }}"> <i class="fa fa-list-alt"></i> Cotizaciones</a>
                        </li>
                        @role('admin')
                        <li {{ (Request::is('product/documents') ||
                                Request::is('product/documents/new') ||
                                Request::is('product/documents/edit/*') ||
                                Request::is('product/documents/delete/*') ? 'class=active' : '') }}>
                            <a href="{{ url('product/documents') }}"> <i class="fa fa-file-text"></i> Documentos</a>
                        </li>
                        @endrole
                        <li {{ (Request::is('product/movements') ||
                                Request::is('product/movements/new') ||
                                Request::is('product/movements/edit/*') ||
                                Request::is('product/movements/delete/*') ? 'class=active' : '') }}>
                            <a href="{{ url('product/movements') }}"> <i class="fa fa-history"></i> Movimientos</a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>
        <div class="sidebar-overlay" id="sidebar-overlay"></div>

        <!-- Content -->
        @yield('content')

    </div>
    <script src="js/vendor.js"></script>
    <script src="js/app.js"></script>
    @yield('page-script')

</div>
</body>


</html>
