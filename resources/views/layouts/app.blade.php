<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="shortcut icon" href="{{ asset('images/favicon.webp') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/proxima-nova.css') }}">
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{--  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">  --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    @yield('appHeader')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div id="app">

        @include('includes.navbar')

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('vendor/vue/vue.js') }}"></script>
    <script src="{{ asset('vendor/vue/axios.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/mixins.js') }}"></script>
    <script src="{{ asset('vendor/ladda/vue-ladda.js') }}"></script>
    <script src="{{ asset('vendor/toast/vue-toastr.umd.min.js') }}"></script>

    {{-- <script>
        $("#navbarTop").scrollspy({ offset: -75 });
    </script> --}}

    <script>
        @auth
        axios.defaults.headers.common["Authorization"] = 'Bearer {{ Auth::user()->access_token }}';
        @endauth

        new Vue({
            el: '#navbarTop',
            methods:{
                /**
                 * Cierra la sesión de un usuario
                 */
                logout(){
                    axios
                    .post("{{ url('api') }}/logout")
                    .then(resp => {
                        location.href = '{{ url("/logout") }}';
                    })
                    .catch(err => { });
                }
            }
        })
    </script>

    @yield('appFooter')
</body>
</html>
