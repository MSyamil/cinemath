<nav class="w-full absolute top-0 left-0 z-50 bg-gradient-to-b from-black/90 via-black/50 to-transparent pt-4 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-14">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="text-netflix-red font-bold text-3xl tracking-tight transition hover:opacity-80">
                    CineMatch
                </a>
            </div>

            <!-- Search Bar -->
            {{-- <div class="hidden md:flex flex-1 max-w-md mx-8 justify-center">
                <div class="relative w-full max-w-sm rounded-sm bg-black/60 border border-gray-600/50 flex items-center px-4 py-1.5 focus-within:ring-1 focus-within:ring-gray-400 transition-all duration-300">
                    <svg class="h-5 w-5 text-gray-400 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" placeholder="Search titles..." class="bg-transparent border-none w-full text-white placeholder-gray-400 focus:outline-none focus:ring-0 ml-3 text-sm h-7">
                </div>
            </div> --}}

            <!-- Right side icons -->
            <div class="flex items-center space-x-6">
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
                            <a href="{{ route('biometric.settings') }}" class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white transition-colors flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993m1.989 3.559A11.209 11.209 0 0 0 8.25 10.5a3.75 3.75 0 1 1 7.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 0 1-3.6 9.75m6.633-4.596a18.666 18.666 0 0 1-2.485 5.33" />
                                </svg>
                                Biometric Settings
                            </a>
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
