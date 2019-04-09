<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @if(auth()->check())
    @include('inc.javascript')
    @endif

</head>
<body>
    <div id="app">
        @include('inc.navbar')

        <div class="container">
        @if(Request::is('/'))
                @include('inc.showcase')
        @endif

        @if(Request::is('zoocard'))

             <div class="row">
                 <div class="col-md-8 col-lg-8">
                     <br>
                     @include('inc.message')
                     @yield('content')
                 </div>
                 <div class="col-md-4 col-lg-4">
                     @include('inc.sidebar')
                 </div>
             </div>
        @else
            <br>
            @include('inc.message')
            @yield('content')
        @endif
        </div>
    </div>

</body>

</html>
