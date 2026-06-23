<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HomeEase')</title>
    <meta name="description" content="@yield('meta_description', 'Book trusted electricians, plumbers, AC repair experts, and drivers near you with transparent pricing on HomeEase.')">
    <meta name="keywords" content="@yield('meta_keywords', 'electrician near me, plumber near me, AC repair near me, driver service, home services India, fixed price home services')">
    <meta name="author" content="Homiease">
    <meta name="robots" content="@yield('meta_robots', 'index,follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <link rel="alternate" hreflang="en-in" href="@yield('canonical', url()->current())">
    <meta property="og:locale" content="en_IN">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title', 'HomeEase')))">
    <meta property="og:description" content="@yield('og_description', trim($__env->yieldContent('meta_description', 'Book trusted electricians, plumbers, AC repair experts, and drivers near you with transparent pricing on HomeEase.')))">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:site_name" content="Homiease">
    <meta property="og:image" content="@yield('og_image', asset('logo.png'))">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@homiease">
    <meta name="twitter:title" content="@yield('twitter_title', trim($__env->yieldContent('title', 'HomeEase')))">
    <meta name="twitter:description" content="@yield('twitter_description', trim($__env->yieldContent('meta_description', 'Book trusted electricians, plumbers, AC repair experts, and drivers near you with transparent pricing on HomeEase.')))">
    <meta name="twitter:image" content="@yield('twitter_image', asset('logo.png'))">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}">
    <link rel="preload" href="{{ asset('favicon.svg') }}" as="image" type="image/svg+xml">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <meta name="theme-color" content="#7C3AED">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="HomeEase">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        window.HomeEaseFirebaseConfig = {
            apiKey: 'AIzaSyAhYidkUMumBt89hXLGSYyWyjN-Lf1qOx4',
            authDomain: 'testingappcodie.firebaseapp.com',
            projectId: 'testingappcodie',
            storageBucket: 'testingappcodie.firebasestorage.app',
            messagingSenderId: '957303316946',
            appId: '1:957303316946:web:d1a2f11a915a22a6f8a80b',
            measurementId: 'G-1B1C35DQC2',
        };
        window.HomeEaseFirebaseVapidKey = 'BOZzWIvA-yRGKY6c3vZzol3h4jVVQOQERLt-PyniM52E2fqoS4gED6zgAW5l-VEpcGE2aXBevciNfhcdg4qKvG4';
    </script>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        /* Layout base styles */
        html { height: 100%; }
        body { min-height: 100vh; margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
    </style>
    @yield('structured_data')
</head>
<body>

@include('layouts.loader')

    @include('layouts.header')

    <main class="page-content">
        @yield('content')
    </main>

</body>

</html>

