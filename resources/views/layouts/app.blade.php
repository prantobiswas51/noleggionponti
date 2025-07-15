<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/storage/images/main_logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Include html5-qrcode -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen ">
        
        @auth
            @include('layouts.navigation')
        @else
            <div class="p-6  bg-black text-white">
                <div class="mx-auto max-w-7xl flex justify-between">
                    <div class="">{{ config('app.name', 'Laravel') }}</div>
                    <div class="gap-3 flex">
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    </div>
                </div>
            </div>
        @endauth

        @if(session('error'))
        <div class="fixed top-[100px] left-1/2 transform -translate-x-1/2 z-50">
            <div
                class="bg-red-600 text-white shadow-lg rounded-md px-6 py-3 w-auto max-w-full text-center animate-fade-in">
                {{ session('error') }}
            </div>
        </div>

        <style>
            @keyframes fade-in {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in {
                animation: fade-in 0.3s ease-out;
            }
        </style>
        @endif

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        @include('layouts.footer')

    </div>
</body>

</html>