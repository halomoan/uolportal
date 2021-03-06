<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UOLPortal') }}</title>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>
<body>
    <div id="app">
        @include('inc.navbar')

        <div class="container">
            @if(Request::is('/'))
                    @include('inc.showcase')
            @endif

            @if(isset($withsidebar) && $withsidebar)

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
            <footer class="row">
                @include('inc.footer')
            </footer>

        </div>
    </div>
    <!-- Scripts -->

    <script>
        window.Laravel = {!! json_encode([
       'csrfToken' => csrf_token(),
       'apiToken' =>  Auth::User()->api_token  ?? null,
       ]) !!};
    </script>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <script>
        var botmanWidget = {
            aboutText: "{{Auth::guest() ? 'Guest' : Auth::user()->name}}",
            title: "UOL ChatBot",
            introMessage: "Welcome to UOLChatBot",
            userId: "{{Auth::guest() ? 'Guest' : Auth::user()->name}}"
        };

    </script>
    <script src='/js/widget.js'></script>


    @if(auth()->check())
        @include('inc.javascript')
    @endif

</body>

</html>
