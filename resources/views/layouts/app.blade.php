<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CineMatch</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .bg-cinematic {
            background-color: #0b0c10;
            background-image: 
                radial-gradient(circle at top right, rgba(229, 9, 20, 0.15) 0%, transparent 40%),
                radial-gradient(circle at bottom left, rgba(20, 20, 20, 0.9) 0%, transparent 50%),
                url('https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=2025&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-blend-mode: overlay;
        }
    </style>
</head>
<body class="font-sans antialiased text-white @yield('body_class', 'min-h-screen') flex flex-col @yield('bg_class', 'bg-cinematic') relative">
    
    @unless(View::hasSection('hide_overlay'))
    <!-- Blur Overlay for cinematic feel -->
    <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px] z-0 pointer-events-none"></div>
    @endunless

    <div class="relative z-10 flex flex-col @yield('wrapper_class', 'min-h-screen')">
        <!-- Navigation -->
        @hasSection('navigation')
            @yield('navigation')
        @else
            <x-nav />
        @endif

        <!-- Main Content -->
        <main class="flex-grow flex items-center justify-center @yield('main_padding', 'pt-24 pb-8 px-4 sm:px-6 lg:px-8')">
            @yield('content')
        </main>

        <!-- Footer -->
        {{-- <footer class="py-6 border-t border-glass-border bg-black/60 backdrop-blur-md mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between text-gray-400 text-sm">
                <div class="mb-4 md:mb-0">
                    &copy; {{ date('Y') }} CineMatch
                </div>
                <div class="flex space-x-6 items-center">
                    <a href="#" class="hover:text-white transition">Privacy</a>
                    <a href="#" class="hover:text-white transition">Terms</a>
                    <a href="#" class="hover:text-white transition">Help</a>
                    <button class="bg-gray-800/80 hover:bg-gray-700 border border-gray-700 text-white rounded-full p-2 transition ml-4 hidden md:block">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                        </svg>
                    </button>
                </div>
            </div>
        </footer> --}}
    </div>
    @yield('scripts')
</body>
</html>
