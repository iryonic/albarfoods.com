<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Al Barr (Khalis Wa Shifaf) - Direct from Srinagar, J&K. Buy premium organic dry fruits, Kashmiri Mogra Saffron (Kesar), raw walnuts, organic pulses, dried seeds, and local spices.')">
    <title>@yield('title', 'Al Barr | Khalis Wa Shifaf - Premium Kashmiri Dry Fruits & Saffron')</title>
    
    <!-- PWA & Mobile Optimization -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0B192C">
    
    <!-- CSS Foundations -->
    <link rel="stylesheet" href="/assets/css/variables.css?v={{ time() }}">
    <link rel="stylesheet" href="/assets/css/main.css?v={{ time() }}">
    <link rel="stylesheet" href="/assets/css/components.css?v={{ time() }}">
    
    @yield('styles')
</head>
<body>

    <!-- Header Include -->
    @include('layouts.header')

    <!-- Main Content Yield -->
    @yield('content')

    <!-- Drawer, Modals & Toast Containers -->
    @include('layouts.sidebar-cart')
    @include('layouts.quick-view')
    
    <div class="toast-container" id="toast-container"></div>

    <!-- Footer Include -->
    @include('layouts.footer')

    @yield('scripts')

</body>
</html>
