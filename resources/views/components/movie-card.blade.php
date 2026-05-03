@props(['movie', 'isFirst' => false, 'isWatched' => false])

<div x-data="{ 
        watched: {{ $isWatched ? 'true' : 'false' }}, 
        showModal: false,
        toggleWatched() {
            this.watched = !this.watched;
            fetch('/movies/{{ $movie['id'] }}/toggle-watched', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).catch(err => {
                this.watched = !this.watched; // revert on error
                console.error(err);
            });
        }
     }" 
     class="group relative flex flex-col {{ $isFirst ? 'ring-2 ring-[#E50914] shadow-[0_0_20px_rgba(229,9,20,0.3)] rounded-2xl' : 'hover:scale-105 transition-transform duration-300' }}">
    
    <!-- Clickable wrapper for Modal -->
    <div @click="showModal = true" class="cursor-pointer w-full h-full flex flex-col">
        <!-- Image Container with Aspect Ratio -->
        <div class="relative w-full aspect-[2/3] rounded-2xl overflow-hidden bg-gray-900 border border-white/5">
        <!-- Poster Image -->
        <img 
            src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" 
            alt="{{ $movie['title'] }}" 
            class="w-full h-full object-cover transition duration-500 group-hover:brightness-110 {{ $isFirst ? '' : 'grayscale-[20%] group-hover:grayscale-0' }}"
            loading="lazy"
        >
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/20 pointer-events-none"></div>

        <!-- Badges -->
        @if($isFirst)
            <!-- Top Left - BEST CHOICE -->
            <div class="absolute top-3 left-3 bg-blue-600/90 backdrop-blur-md px-2.5 py-1 rounded-full text-[0.6rem] font-bold text-white tracking-wider uppercase shadow-lg">
                BEST CHOICE
            </div>
            <!-- Top Right - Red Match Badge -->
            <div class="absolute top-3 right-3 bg-[#E50914] px-2.5 py-1 rounded-full text-[0.7rem] font-bold text-white flex items-center shadow-[0_0_10px_rgba(229,9,20,0.5)] z-10">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-2.5 h-2.5 mr-1">
                  <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                </svg>
                {{ $movie['match_score'] ?? 0 }}% Match
            </div>
        @else
            <!-- Standard Match Badge -->
            <div class="absolute top-3 right-3 bg-black/60 backdrop-blur-md px-2.5 py-1 rounded-full text-[0.7rem] font-medium text-gray-200 border border-white/10 z-10">
                {{ $movie['match_score'] ?? 0 }}% Match
            </div>
        @endif

        <!-- Watched Toggle Button (Only for Auth) -->
        @auth
        <button @click.stop="toggleWatched()" 
                class="absolute bottom-3 right-3 p-2 rounded-full transition-all duration-300 z-10 shadow-lg"
                :class="watched ? 'bg-[#E50914] text-white hover:bg-red-700' : 'bg-black/60 text-white hover:bg-white hover:text-black border border-white/20 backdrop-blur-md'">
            <!-- Eye icon -->
            <svg x-show="!watched" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <!-- Check icon (Watched) -->
            <svg x-show="watched" style="display: none;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
              <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
            </svg>
        </button>
        @endauth
    </div>

    <!-- Text Information -->
    <div class="pt-4 px-1">
        <h3 class="text-lg font-medium text-white tracking-wide truncate group-hover:text-[#E50914] transition-colors">
            {{ $movie['title'] ?? 'Unknown' }}
        </h3>
        <div class="flex items-center text-xs text-gray-400 mt-1.5 font-medium">
            <span>{{ isset($movie['release_date']) ? substr($movie['release_date'], 0, 4) : 'N/A' }}</span>
            <span class="mx-1.5 my-auto h-1 w-1 rounded-full bg-gray-600"></span>
            @php
                $genreMap = [
                    28 => 'Action', 12 => 'Adventure', 16 => 'Animation', 35 => 'Comedy', 80 => 'Crime', 99 => 'Documentary', 18 => 'Drama', 10751 => 'Family', 14 => 'Fantasy', 36 => 'History', 27 => 'Horror', 10402 => 'Music', 9648 => 'Mystery', 10749 => 'Romance', 878 => 'Sci-Fi', 10770 => 'TV Movie', 53 => 'Thriller', 10752 => 'War', 37 => 'Western'
                ];
                $genres = array_map(function($id) use ($genreMap) {
                    return $genreMap[$id] ?? 'Other';
                }, array_slice($movie['genre_ids'] ?? [], 0, 2));
            @endphp
            <span class="truncate">{{ implode(' • ', $genres) }}</span>
        </div>
    </div>
    </div>

    <!-- Modal -->
    <template x-teleport="body">
        <div x-show="showModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" style="display: none;">
            
            <!-- Backdrop -->
            <div x-show="showModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showModal = false"
                 class="absolute inset-0 bg-black/80 backdrop-blur-sm">
            </div>

            <!-- Modal Content -->
            <div x-show="showModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="relative bg-[#141414] border border-white/10 rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden w-full max-w-4xl max-h-[90vh] flex flex-col md:flex-row">
                
                <!-- Close Button -->
                <button @click="showModal = false" class="absolute top-4 right-4 z-20 p-2 bg-black/50 hover:bg-[#E50914] text-white rounded-full backdrop-blur-md transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Left: Poster Image -->
                <div class="w-full md:w-2/5 flex-shrink-0 relative">
                    <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}" class="w-full h-full object-cover max-h-[40vh] md:max-h-full">
                    <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-[#141414] via-transparent to-transparent pointer-events-none"></div>
                </div>

                <!-- Right: Details -->
                <div class="w-full md:w-3/5 p-6 sm:p-8 md:p-10 flex flex-col overflow-y-auto custom-scrollbar">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-2">{{ $movie['title'] ?? 'Unknown' }}</h2>
                    
                    <div class="flex flex-wrap items-center text-sm text-gray-300 font-medium mb-6 gap-3">
                        <span class="bg-[#E50914]/20 text-[#E50914] px-2.5 py-1 rounded-md border border-[#E50914]/30">
                            {{ isset($movie['release_date']) ? substr($movie['release_date'], 0, 4) : 'N/A' }}
                        </span>
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-yellow-500 mr-1">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                            </svg>
                            {{ number_format($movie['vote_average'] ?? 0, 1) }} / 10
                        </span>
                        <span class="text-gray-500">•</span>
                        <span>{{ implode(', ', $genres) }}</span>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-white mb-2">Kilasan Singkat</h3>
                        <p class="text-gray-400 leading-relaxed text-sm sm:text-base">
                            {{ !empty($movie['overview']) ? $movie['overview'] : 'Tidak ada kilasan singkat yang tersedia dari API untuk film ini.' }}
                        </p>
                    </div>

                    <!-- Action buttons inside modal -->
                    <div class="mt-auto pt-6 flex gap-4">
                        <button class="flex-1 bg-white text-black font-bold py-3 px-6 rounded-xl hover:bg-gray-200 transition-colors flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                              <path fill-rule="evenodd" d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653Z" clip-rule="evenodd" />
                            </svg>
                            Watch Trailer
                        </button>
                        @auth
                            <button @click="toggleWatched()" 
                                    class="p-3 rounded-xl border transition-colors flex justify-center items-center"
                                    :class="watched ? 'bg-[#E50914]/20 border-[#E50914]/50 text-[#E50914]' : 'bg-white/5 border-white/10 text-white hover:bg-white/10'">
                                <svg x-show="!watched" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <svg x-show="watched" style="display: none;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                  <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
