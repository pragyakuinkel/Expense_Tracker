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
<body class="flex items-center justify-center min-h-screen p-6 bg-gradient-to-br from-gray-100 to-blue-100">
<div class="w-full max-w-4xl bg-white rounded-xl shadow-lg overflow-hidden">
    <header class="bg-gray-800 text-white p-4 flex justify-between items-center">
        <h1 class="text-xl">Expense Tracker</h1>
        @if (Route::has('login'))
            <nav class="flex gap-2">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="text-white px-3 py-1 rounded" style="background-color:#0ea5e9">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="bg-transparent border border-green-400 text-green-400 px-3 py-1 rounded">
                        Log In
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class=" text-white px-3 py-1 rounded" style="background-color:#0ea5e9">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <main class="p-6 flex flex-col lg:flex-row gap-6">
        <div class="flex-1">
            <h2 class="text-3xl font-semibold text-gray-800 mb-4">Track Your Expenses with Ease</h2>
            <p class="text-gray-600 mb-6">Take control of your finances with our intuitive expense tracking system.</p>

            <ul class="text-gray-700 space-y-3">
                <li class="flex items-center gap-2">
                    <span class="text-green-500">✓</span> Record daily expenses effortlessly
                </li>
                <li class="flex items-center gap-2">
                    <span class="text-green-500">✓</span> Categorize spending with custom tags
                </li>
                <li class="flex items-center gap-2">
                    <span class="text-green-500">✓</span> Generate insightful reports
                </li>
                <li class="flex items-center gap-2">
                    <span class="text-green-500">✓</span> Set budget goals and alerts
                </li>
            </ul>

            @auth
                <a href="{{ url('/dashboard') }}"
                   class="inline-block mt-6 text-white px-6 py-3 rounded-lg  transition-all duration-300 transform hover:scale-105" style="background-color:#0ea5e9">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}"
                   class="inline-block mt-6  text-white px-6 py-3 rounded-lg  transition-all duration-300 transform hover:scale-105" style="background-color:#0ea5e9">
                    Get Started Now
                </a>
            @endauth
        </div>

        <div class="lg:w-1/2 flex items-center justify-center">
            <div class="bg-gray-100 rounded-lg p-6 w-full h-full flex items-center justify-center">
                <svg class="w-32 h-32 " fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#0ea5e9">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </main>
</div>
</body>
</html>
