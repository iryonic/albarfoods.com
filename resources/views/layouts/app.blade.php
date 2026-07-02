<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Al Barr (Khalis Wa Shifaf) - Direct from Srinagar, J&K. Buy premium organic dry fruits, Kashmiri Mogra Saffron (Kesar), raw walnuts, organic pulses, dried seeds, and local spices.')">
    <title>@yield('title', 'Al Barr | Khalis Wa Shifaf - Premium Kashmiri Dry Fruits & Saffron')</title>
    
    <!-- PWA & Mobile Optimization -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0B192C">
    
    <!-- CSS Foundations -->
    <link rel="stylesheet" href="{{ asset('assets/css/variables.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}?v={{ time() }}">
    
    @yield('styles')
</head>
<body class="@yield('body_class')">

    <!-- Header Include -->
    @if (!request()->routeIs('signin') && !request()->routeIs('signup'))
        @include('layouts.header')
    @endif

    <!-- Main Content Yield -->
    @yield('content')

    <!-- Drawer, Modals & Toast Containers -->
    @if (!request()->routeIs('signin') && !request()->routeIs('signup'))
        @include('layouts.sidebar-cart')
        @include('layouts.quick-view')
    @endif
    
    <div class="toast-container" id="toast-container"></div>

    <!-- Footer Include -->
    @if (!request()->routeIs('signin') && !request()->routeIs('signup'))
        @include('layouts.footer')
    @endif

    @yield('scripts')

</body>
</html>
