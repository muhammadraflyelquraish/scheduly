<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Scheduly | Login</title>

    <link href="{{ asset('assets') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="{{ asset('assets') }}/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/css/plugins/ladda/ladda-themeless.min.css" rel="stylesheet">

    <link href="{{ asset('assets') }}/css/animate.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/css/style.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            font-family: 'Rubik', sans-serif;
        }
    </style>

</head>

<body class="gray-bg">

    <div class="passwordBox animated fadeInDown">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox-content">
                    <h2 class="font-bold">Scheduly</h2>
                    <p>
                        Login
                    </p>
                    <form class="m-t" role="form" method="POST" action="{{ route('login.store') }}">
                        @csrf

                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
                            @if($errors->has('email'))
                            <small class="text-danger" id="email_error">
                                {{ $errors->first('email') }}
                            </small>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" autocomplete="off" placeholder="Password" name="password" required>
                            <small class="text-danger" id="password_error"></small>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <div class="i-checks"><label> <input type="checkbox" name="remember"><i></i> Ingat Saya? </label></div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b ladda-button ladda-button-demo" data-style="zoom-in">Login</button>
                    </form>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-12">
                &copy; <small>{{ date('Y') }} &bullet; Scheduly</small>
            </div>

        </div>
    </div>

    <script src="{{ asset('assets') }}/js/jquery-3.1.1.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/iCheck/icheck.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Ladda -->
    <script src="{{ asset('assets') }}/js/plugins/ladda/spin.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/ladda/ladda.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/ladda/ladda.jquery.min.js"></script>

</body>

</html>