<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Foundlessness</title>
    <!--styles-->
    <link href="{{ asset('css/app.css') }}" type="text/css" rel="stylesheet"/>
    <link href="{{ asset('css/styles.css') }}" type="text/css" rel="stylesheet"/>
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    <!--scripts-->
    <script>
        @if(\Illuminate\Support\Facades\Auth::check())
            window.user = @json(
            [
                'user'=> auth()->user(),
                'roles'=>auth()->user()->roles,
                'permissions'=> auth()->user()->getAllPermissions()
            ]
            );
        @endif
    </script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
</body>
</html>
