@props(['wRating' => 70, 'wPopularity' => 30, 'comparisonValue' => 5, 'selectedGenre' => null, 'watchedFilter' => 'all'])

@php
    $genreNameMap = [
        28 => 'Action', 12 => 'Adventure', 16 => 'Animation', 35 => 'Comedy', 80 => 'Crime', 99 => 'Documentary', 18 => 'Drama', 10751 => 'Family', 14 => 'Fantasy', 36 => 'History', 27 => 'Horror', 10402 => 'Music', 9648 => 'Mystery', 10749 => 'Romance', 878 => 'Sci-Fi', 10770 => 'TV Movie', 53 => 'Thriller', 10752 => 'War', 37 => 'Western'
    ];
    $genreName = $selectedGenre ? ($genreNameMap[$selectedGenre] ?? '') : '';
@endphp

<nav class="w-full relative z-50 bg-[#0b0c10] border-b border-white/5 py-4">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-10">
            <!-- Left Side -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <a href="/" class="text-gray-200 font-medium text-2xl tracking-tight transition hover:opacity-80">
                    CineMatch
                </a>

                <!-- Back to Adjust Preferences -->
                <a href="/" class="hidden md:flex items-center text-sm text-gray-400 hover:text-white transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Back to Adjust Preferences
                </a>

                <!-- Genres Dropdown using Alpine.js for interactivity -->
                <div x-data="{ open: false }" class="relative hidden lg:block">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-2 text-sm text-gray-300 bg-white/5 hover:bg-white/10 px-4 py-2 rounded-lg border border-white/5 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                        </svg>
                        <span>{{ $selectedGenre ? 'Genre: ' . $genreName : 'All Genres' }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3 ml-1 opacity-70 transition-transform duration-200" :class="open ? 'rotate-180' : ''">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu Form -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute z-50 mt-2 w-48 rounded-xl shadow-2xl bg-[#141414] border border-white/10 py-2" 
                         style="display: none;">
                        <form action="{{ route('process') }}" method="POST" id="genreForm">
                            @csrf
                            <input type="hidden" name="comparison_value" value="{{ $comparisonValue }}">
                            <input type="hidden" name="watched_filter" value="{{ $watchedFilter }}">
                            
                            @php
                                $genres = [
                                    '' => 'All Genres', 28 => 'Action', 12 => 'Adventure', 16 => 'Animation', 35 => 'Comedy', 80 => 'Crime', 99 => 'Documentary', 18 => 'Drama', 10751 => 'Family', 14 => 'Fantasy', 36 => 'History', 27 => 'Horror', 10402 => 'Music', 9648 => 'Mystery', 10749 => 'Romance', 878 => 'Sci-Fi', 10770 => 'TV Movie', 53 => 'Thriller', 10752 => 'War', 37 => 'Western'
                                ];
                            @endphp

                            @foreach($genres as $id => $name)
                                <button type="submit" name="genre" value="{{ $id }}" class="w-full text-left px-4 py-2 text-sm {{ $selectedGenre == $id ? 'bg-[#E50914]/20 text-white font-medium' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} transition-colors">
                                    {{ $name }}
                                </button>
                            @endforeach
                        </form>
                    </div>
                </div>

                <!-- Watched Filter Dropdown (Only for Auth) -->
                @auth
                <div x-data="{ open: false }" class="relative hidden lg:block">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-2 text-sm text-gray-300 bg-white/5 hover:bg-white/10 px-4 py-2 rounded-lg border border-white/5 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span>
                            @if($watchedFilter == 'watched') Sudah Ditonton
                            @elseif($watchedFilter == 'unwatched') Belum Ditonton
                            @else Semua Tontonan
                            @endif
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3 ml-1 opacity-70 transition-transform duration-200" :class="open ? 'rotate-180' : ''">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute z-50 mt-2 w-48 rounded-xl shadow-2xl bg-[#141414] border border-white/10 py-2" 
                         style="display: none;">
                        <form action="{{ route('process') }}" method="POST">
                            @csrf
                            <input type="hidden" name="comparison_value" value="{{ $comparisonValue }}">
                            <input type="hidden" name="genre" value="{{ $selectedGenre }}">
                            
                            @php
                                $filters = [
                                    'all' => 'Semua Tontonan',
                                    'watched' => 'Sudah Ditonton',
                                    'unwatched' => 'Belum Ditonton'
                                ];
                            @endphp

                            @foreach($filters as $val => $label)
                                <button type="submit" name="watched_filter" value="{{ $val }}" class="w-full text-left px-4 py-2 text-sm {{ $watchedFilter == $val ? 'bg-[#E50914]/20 text-white font-medium' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} transition-colors">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </form>
                    </div>
                </div>
                @endauth
            </div>

            <!-- Right side icons & info -->
            <div class="flex items-center space-x-6">
                
                <!-- Dynamic Weights Display -->
                <div class="hidden md:flex items-center bg-[#1a1c23] border border-white/10 rounded-full px-5 py-1.5 text-[0.7rem] font-bold tracking-widest text-gray-400">
                    <span>RATING: {{ $wRating }}%</span>
                    <span class="mx-3 opacity-30">|</span>
                    <span>POPULARITY: {{ $wPopularity }}%</span>
                </div>

                @guest
                    <a href="{{ route('login') }}" class="text-sm font-medium text-white hover:text-[#E50914] transition-colors">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-[#E50914] hover:bg-red-700 text-white text-sm font-medium py-1.5 px-4 rounded-lg transition-colors shadow-lg shadow-red-900/20">Sign Up</a>
                @else
                    <!-- User Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-3 focus:outline-none">
                            <span class="text-sm font-medium text-gray-200 hidden sm:block">{{ Auth::user()->username }}</span>
                            <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-[#E50914] to-red-900 flex items-center justify-center text-white font-bold shadow-md transition duration-200 hover:ring-2 ring-white/20">
                                {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                            </div>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute right-0 z-50 mt-2 w-48 rounded-xl shadow-2xl bg-[#141414] border border-white/10 py-2" 
                             style="display: none;">
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white transition-colors flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
