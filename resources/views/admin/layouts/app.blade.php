<!DOCTYPE html>

<html lang="fr">

@section('html.head')
    @include('admin.layouts.partials.html.head')
@show

<body class="{{ config('admin.skin') }} {{ config('admin.layout') }}">
<div class="wrapper">

    @include('admin.layouts.partials.navigation.mainheader')

    @include('admin.layouts.partials.navigation.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        
        @if(!isset($no_header))
            @include('admin.layouts.partials.navigation.contentheader')
        @endif
        

        <!-- Main content -->
        <section class="content {{ $no_padding or '' }}">
            <!-- Your Page Content Here -->
            @yield('main-content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    @include('admin.layouts.partials.navigation.footer')

</div><!-- ./wrapper -->


@section('scripts')
    @include('admin.layouts.partials.html.scripts')
@show

</body>
</html>
