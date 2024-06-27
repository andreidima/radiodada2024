<!doctype html>
<html class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Font Awesome links -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body class="d-flex flex-column h-100">

    <main class="flex-shrink-0 py-0">
        <a href="https://www.radiodada.ro" target="_top">
            {{-- <div class="container"> --}}
            <div class="row mb-2">
                <div class="col-lg-12" style="text-align: center">
                    <img class="rounded-3 m-0"
                        src="{{url('/images/headerSiteMeniu2.png')}}"
                        style="width:1213px; max-width: 100%;"
                        >
                </div>
                <div class="col-gl-12 bg-black" style="text-align: center">
                        <img class="rounded-3 m-0"
                            src="{{url('/images/headerSiteBanner.png')}}"
                            style="width:1143px; max-width: 100%;"
                            >
                </div>
            </div>
            {{-- </div> --}}
        </a>

        @yield('content')
    </main>
</body>
</html>
