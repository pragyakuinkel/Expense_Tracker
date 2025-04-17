<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Expense Tracker</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
<header class="bg-[#0ea5e9] text-white p-4 flex justify-between items-center">
    <div class="flex items-center gap-3">
        <svg class="w-8 h-8" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="25" y="25" width="50" height="50" rx="10" fill="white" fill-opacity="0.2"/>
            <path d="M50 20V30M50 70V80" stroke="white" stroke-width="4" stroke-linecap="round"/>
            <path d="M40 40L60 60M60 40L40 60" stroke="white" stroke-width="4" stroke-linecap="round"/>
        </svg>
        <h1 class="text-xl">Expense Tracker</h1>
    </div>
    @if (Route::has('login'))
        <nav class="flex gap-2">
            @auth
                <a href="
                    @if(Auth::user()->hasRole(1))
                    {{ url('/admin/dashboard') }}
                    @else
                    {{ url('/dashboard') }}
                    @endif
                "
                   class="text-white px-3 py-1 rounded" style="background-color:#0ea5e9">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="bg-transparent border border-white text-white px-3 py-1 rounded">
                    Log In
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="text-[#0ea5e9] px-3 py-1 rounded bg-white">
                        Register
                    </a>
                @endif
            @endauth
        </nav>
    @endif
</header>

<main class="flex flex-col lg:flex-row min-h-[calc(100vh-72px)]">
    <div class="lg:w-1/2 p-8 lg:p-16 flex flex-col justify-center bg-white">
        <h2 class="text-4xl font-semibold text-gray-800 mb-6">Track Your Expenses with Ease</h2>
        <p class="text-gray-600 mb-8 text-lg">Take control of your finances with our intuitive expense tracking system.</p>
        @auth
            <a href="
                @if(Auth::user()->hasRole(1))
                {{ url('/admin/dashboard') }}
                @else
                {{ url('/dashboard') }}
                @endif
            "
               class="inline-block text-white px-8 py-4 rounded-lg transition-all duration-300 transform hover:scale-105 text-lg" style="background-color:#0ea5e9">
                Go to Dashboard
            </a>
        @else
            <a href="{{ route('register') }}"
               class="text-center inline-block text-white px-8 py-4 rounded-lg transition-all duration-300 transform hover:scale-105 text-lg" style="background-color:#0ea5e9">
                Get Started Now
            </a>
        @endauth
    </div>

    <div class="lg:w-1/2 flex items-center justify-center">
        <img src="{{ asset('image/icon.png') }}" alt="Expense Tracker Illustration" class="max-w-full max-h-[500px] object-contain p-8">
    </div>
</main>
</body>
</html>
