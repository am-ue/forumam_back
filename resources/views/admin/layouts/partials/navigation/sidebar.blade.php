<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (Auth::check())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ asset(Auth::user()->company->logo) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->full_name }}</p>
                    <small>{{ Auth::user()->company->name }}</small>
                </div>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Administration</li>
            <li class="{{areActiveRoutes('admin.home')}}"><a href="{{ route('admin.home') }}"><i class='fa fa-home'></i> <span>Dashboard</span></a></li>
            @php
            $menu = [
                'users' => [
                    'Les utilisateurs',
                    'users'
                ],
                'companies' => [
                    'Les entreprises',
                    'building'
                ],
                'categories' => [
                    'Les catégories',
                    'map-marker'
                ],
                'options' => [
                    'Les options',
                    'sliders'
                ]
            ]
            @endphp

            @foreach($menu as $model => list($label, $fa))
                <li class="{{areActiveRoutes('admin.'.$model)}}"><a href="{{ route('admin.'.$model.'.index') }}"><i class='fa fa-{{$fa}}'></i> <span>{{$label}}</span></a></li>
            @endforeach
            <li class="header">Ma participation</li>
            <li class="{{areActiveRoutes('admin.users')}}"><a href="{{ route('admin.users.show', Auth::user()->id) }}"><i class='fa fa-user'></i> <span>Mon compte</span></a></li>
            <li class="{{areActiveRoutes('admin.companies')}}"><a href="{{ route('admin.companies.show', Auth::user()->company->id) }}"><i class='fa fa-building'></i> <span>Mon entreprise</span></a></li>
            <li><a href="#"><i class='fa fa-shopping-cart'></i> <span>Ma commande</span></a></li>
            <li><a href="#"><i class='fa fa-users'></i> <span>L'équipe</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
