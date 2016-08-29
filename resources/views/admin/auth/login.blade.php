@extends('admin.layouts.auth')

@section('html.head_title')
    Connexion
@endsection

@section('content')
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('admin.home') }}">{!! config('admin.sitename.html') !!}</a>
        </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Oups !</strong> Il y a eu un problème avec vos identifiants.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="login-box-body">
    <p class="login-box-msg">Connexion</p>
    <form action="{{ route('admin.postLogin') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Adresse email" name="email" required/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Mot de passe" name="password" required/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-offset-8 col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Connexion</button>
            </div><!-- /.col -->
        </div>
    </form>

    <a href="{{ route('admin.passwordReset') }}">Mot de passe oublié</a><br>
    <!--<a href="{{ route('admin.register') }}" class="text-center">Register a new membership</a>-->

</div><!-- /.login-box-body -->

</div><!-- /.login-box -->

    @include('admin.layouts.partials.html.scripts_auth')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

@endsection
