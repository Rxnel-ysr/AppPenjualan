<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link type="text/css" rel="stylesheet" href="{{ asset('css/b5.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')

</head>

<body>
    <div id="app">
        <div class="sidebar h-100 d-flex flex-column">
            <h4 class="text-white">Admin</h4>
            <div>

                <a href="{{ route('dashboard') }}" class="{{ request()->is('/') ? 'active' : '' }}">
                    <i class="bi bi-house-fill me-2"></i> {{ __('Dashboard') }}
                </a>

                <a href="{{ route('sale.index') }}" class="{{ request()->is('sales*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill me-2"></i> {{ __('Sales') }}
                </a>

                <a href="{{ route('item.index') }}" class="{{ request()->is('items*') ? 'active' : '' }}">
                    <i class="bi bi-box-fill me-2"></i> {{ __('Items') }}
                </a>

                <a href="{{ route('category.index') }}" class="{{ request()->is('categories*') ? 'active' : '' }}">
                    <i class="bi bi-puzzle-fill me-2"></i> {{ __('Categories') }}
                </a>

                <a href="{{ route('supplier.index') }}" class="{{ request()->is('suppliers*') ? 'active' : '' }}">
                    <i class="bi bi-person-fill-add me-2"></i> {{ __('Suppliers') }}
                </a>

                <a href="{{ route('purchase.index') }}" class="{{ request()->is('purchases*') ? 'active' : '' }}">
                    <i class="bi bi-currency-dollar me-2"></i> {{ __('Purchases') }}
                </a>

                <a href="{{ route('customer.index') }}" class="{{ request()->is('customers*') ? 'active' : '' }}">
                    <i class="bi bi-person-vcard me-2"></i> {{ __('Customers') }}
                </a>

                <a href="{{ route('profile.edit') }}" class="{{ request()->is('profile*') ? 'active' : '' }}" id="profile">
                    <i class="bi bi-person-circle me-2"></i> {{ __('Profile') }}
                </a>

            </div>
            <hr class="border-1 mt-auto">
            <div class="d-flex flex-row justify-content-center gap-2">
                <i class="bi bi-person-circle"></i><p class="card-title text-muted text-light-emphasis">{{ auth()->user()->username }}</p>
            </div>
        </div>

        <div class="content">
            @yield('content')
        </div>

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
    @stack('scripts')
</body>

</html>