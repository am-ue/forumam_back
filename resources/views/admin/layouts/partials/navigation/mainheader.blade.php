<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ route('admin.home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>{!! config('admin.sitename.short') !!}</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{!! config('admin.sitename.html') !!}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle b-l" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @if (Auth::check())
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ asset('admin-assets/img/user2-160x160.jpg') }}" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
<<<<<<< Updated upstream
                                <img src="{{ asset('admin-assets/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image" />
=======
                                <img src="{{ asset(Auth::user()->company->logo) }}" class="img-circle" alt="User Image" />
>>>>>>> Stashed changes
                                <p>
                                    {{ Auth::user()->name }}
                                    <?php
                                    $datec = Auth::user()['created_at'];
                                    ?>
                                    <small>Member since <?php echo date("M. Y", strtotime($datec)); ?></small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="col-xs-4 text-center">
                                    <a href="{{ url(config('laraadmin.adminRoute') . '/laeditor') }}"><i class="fa fa-code"></i> <span>Edit</span></a>
                                </div>
                                <div class="col-xs-8 text-center">
                                    <a href="{{ url(config('laraadmin.adminRoute') . '/modules') }}"><i class="fa fa-cubes"></i> <span>Module Manager</span></a>
                                </div>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ url(config('laraadmin.adminRoute') . '/user/') }}/{{ Auth::user()->id }}" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>