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
    <link rel="shortcut icon" type="image/x-icon" href="/images/Monad.png"/>
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    <!--scripts-->
    <script>
        @if(\Illuminate\Support\Facades\Auth::check())
            window.user = @json(
            (new \App\Http\Resources\UserResource(Auth::user()))->jsonSerialize()
            );
        @endif
        window.domains = @json(\App\Http\Resources\DomainResource::collection(\App\Models\Domain::all())->jsonSerialize())
    </script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
</body>
</html>
