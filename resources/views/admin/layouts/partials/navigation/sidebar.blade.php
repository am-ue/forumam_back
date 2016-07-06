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
            <li class="{{isActiveRoutes('admin.home')}}"><a href="{{ route('admin.home') }}"><i class='fa fa-home'></i> <span>Dashboard</span></a></li>
            <li class="{{isActiveRoutes(['admin.users.index', 'admin.users.show]'])}}"><a href="{{ route('admin.users.index') }}"><i class='fa fa-users'></i> <span>Les utilisateurs</span></a></li>
            <li class="{{isActiveRoutes('')}}"><a href="#"><i class='fa fa-building'></i> <span>Les entreprises</span></a></li>
            <li class="{{isActiveRoutes('')}}"><a href="#"><i class='fa fa-shopping-cart'></i> <span>Les options</span></a></li>
            <li class="{{isActiveRoutes('')}}"><a href="#"><i class='fa fa-shopping-cart'></i> <span>Les articles</span></a></li>
            <li class="header">Ma participation</li>
            <li><a href="#"><i class='fa fa-list-alt'></i> <span>Ma page publique</span></a></li>
            <li><a href="#"><i class='fa fa-shopping-cart'></i> <span>Ma commande</span></a></li>
            <li><a href="#"><i class='fa fa-users'></i> <span>L'équipe</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
