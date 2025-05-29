<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('css/b5.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <ul class="navbar-nav ms-auto">

                    </ul>
                </div>
            </div>
        </nav>
        <main>
            @yield('content')
        </main>
        <div class="toast-container">
            @php
            $toastColors = [
            'success' => 'bg-success text-white',
            'error' => 'bg-danger text-white',
            'warning' => 'bg-warning text-dark',
            'info' => 'bg-info text-dark',
            ];
            $icons = [
            'success' => 'bi-check-circle-fill',
            'error' => 'bi-x-circle-fill',
            'warning' => 'bi-exclamation-triangle-fill',
            'info' => 'bi-info-circle-fill',
            ];
            @endphp

            @if ($errors->any())
            @foreach ($errors->all() as $err)
            <div class="toast animate__animated animate__fadeInUp align-items-start {{ $toastColors['warning'] }} bg-gradient border-0 shadow-lg show"
                role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body small">
                        <strong><i class="bi bi-x-octagon-fill me-2"></i>Error</strong>
                        <p class="fs-6 m-0">{{ $err }}</p>
                    </div>
                    <!-- <button type="button" class="btn-close btn-close-white me-2 m-auto"data-bs-dismiss="toast" aria-label="Close"></button> -->
                </div>
            </div>
            @endforeach
            @endif

            @foreach (['success', 'error', 'warning', 'info'] as $type)
            @if (session($type))
            <div class="toast animate__animated animate__fadeInUp align-items-start {{ $toastColors[$type] }} bg-gradient border-0 shadow-lg show"
                role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body small">
                        <strong><i class="bi {{ $icons[$type] }} me-2"></i>{{ ucfirst($type) }}</strong>
                        <p class="fs-6 m-0">{{ session($type) }}</p>
                    </div>
                    <!-- <button type="button" class="btn-close @if($type !== 'warning' && $type !== 'info') btn-close-white @endif me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button> -->
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/b5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/helpers.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/helpers.js') }}"></script>
    @stack('scripts')
</body>

</html>