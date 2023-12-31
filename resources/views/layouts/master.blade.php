<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Scheduly | Admin</title>

    <link href="{{ asset('assets') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/css/plugins/iCheck/custom.css" rel="stylesheet">

    <link href="{{ asset('assets') }}/css/dataTables.min.css" rel="stylesheet">
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
    @stack('css')

</head>

<body>

    <div id="wrapper">

        @include('layouts.sidebar')

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <button type="button" class="navbar-minimalize minimalize-styl-2 btn btn-primary"><i class="fa fa-bars"></i></button>
                        <span class="nav minimalize-styl-2">Tanggal :&nbsp;<span id="lifeTime"></span></span>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Scheduly</span>
                        </li>
                    </ul>
                </nav>
            </div>

            @yield('content')

            <div class="footer">
                <div class="float-right">
                    <?= date('Y') ?>
                </div>
                <div>
                    &copy; Scheduly</a>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

</body>

</html>