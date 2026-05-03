<div class="w-full max-w-2xl mx-auto backdrop-blur-2xl bg-[#141414]/70 border border-white/10 rounded-3xl p-8 sm:p-12 shadow-[0_0_50px_rgba(0,0,0,0.8)] relative overflow-hidden">
    <!-- Top badge -->
    {{-- <div class="flex justify-center mb-6">
        <span class="px-5 py-1.5 rounded-full bg-blue-900/40 border border-blue-500/20 text-[#a5c0df] text-xs font-bold tracking-widest uppercase backdrop-blur-md">
            Curated Experience
        </span>
    </div> --}}

    <!-- Main Title -->
    {{-- <h1 class="text-4xl sm:text-[2.75rem] font-bold text-center text-white leading-tight mb-16 tracking-tight">
        What are you in the <br>
        <span class="text-[#E50914]">mood</span> for tonight?
    </h1> --}}
    {{-- revisi --}}
    <h1 class="text-xl sm:text-[2rem] font-bold text-center text-white leading-tight mb-10 tracking-tight">
        What are you in the <br>
        <span class="text-[#E50914]">mood</span> for tonight?
    </h1>

    <!-- Form pointing to route('process') -->
    <form action="{{ route('process') }}" method="POST">
        @csrf
        
        <!-- Interactive Slider with Alpine.js -->
        <div x-data="{ value: 5 }" class="mb-14 relative w-full pt-6">
            
            <!-- Labels above slider -->
            <div class="flex justify-between items-end mb-8 relative z-10">
                <!-- Left Label - Critics -->
                <div class="flex flex-col items-center text-center">
                    <div class="bg-gray-800/80 p-3.5 rounded-full mb-3 shadow-[0_4px_15px_rgba(0,0,0,0.5)] border border-gray-700/50 backdrop-blur-sm">
                        <!-- Star Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-[#ff8b8b]">
                          <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-[0.85rem] font-bold text-gray-200 tracking-wide">Critics Quality<br><span class="text-gray-400 font-medium">(Rating)</span></span>
                </div>

                <!-- Right Label - Popularity -->
                <div class="flex flex-col items-center text-center">
                    <div class="bg-gray-800/80 p-3.5 rounded-full mb-3 shadow-[0_4px_15px_rgba(0,0,0,0.5)] border border-gray-700/50 backdrop-blur-sm">
                        <!-- Flame Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-[#E50914]">
                          <path fill-rule="evenodd" d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.176 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 0 1 1.925-3.546 3.75 3.75 0 0 1 3.255 3.718Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-[0.85rem] font-bold text-gray-200 tracking-wide">Global Hype<br><span class="text-gray-400 font-medium">(Popularity)</span></span>
                </div>
            </div>

            <!-- Custom Slider Track and Input -->
            <div class="relative h-1 bg-gray-600 rounded-full mt-2 w-[85%] mx-auto">
                <input 
                    type="range" 
                    name="comparison_value" 
                    min="1" 
                    max="9" 
                    step="1" 
                    x-model="value"
                    class="absolute w-full h-full opacity-0 cursor-pointer z-20"
                >
                <!-- Interactive Thumb -->
                <div 
                    class="absolute top-1/2 -mt-[14px] w-7 h-7 bg-[#E50914] border-[3px] border-white rounded-full shadow-[0_0_15px_rgba(229,9,20,0.8)] pointer-events-none transition-all duration-75 ease-out z-10"
                    :style="'left: calc(' + ((value - 1) / 8 * 100) + '% - ' + ((value - 1) / 8 * 28) + 'px)'"
                ></div>
            </div>

            <!-- Slider Numbers (1 to 9) -->
            <div class="flex justify-between text-xs font-semibold px-2 mt-6 w-[85%] mx-auto relative z-0">
                <span :class="value == 1 ? 'text-white scale-125 transition-all' : 'text-gray-500'">1</span>
                <span :class="value == 2 ? 'text-white scale-125 transition-all' : 'text-gray-500'">2</span>
                <span :class="value == 3 ? 'text-white scale-125 transition-all' : 'text-gray-500'">3</span>
                <span :class="value == 4 ? 'text-white scale-125 transition-all' : 'text-gray-500'">4</span>
                <span :class="value == 5 ? 'text-white scale-125 transition-all' : 'text-gray-500'">5</span>
                <span :class="value == 6 ? 'text-white scale-125 transition-all' : 'text-gray-500'">6</span>
                <span :class="value == 7 ? 'text-white scale-125 transition-all' : 'text-gray-500'">7</span>
                <span :class="value == 8 ? 'text-white scale-125 transition-all' : 'text-gray-500'">8</span>
                <span :class="value == 9 ? 'text-white scale-125 transition-all' : 'text-gray-500'">9</span>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-[90%] mx-auto py-4 px-6 rounded-2xl bg-gradient-to-r from-[#ff6b6b] via-[#E50914] to-[#c10710] hover:from-[#ff5252] hover:to-[#b0060e] text-white font-bold text-[1.1rem] tracking-wide shadow-[0_8px_30px_rgba(229,9,20,0.3)] hover:shadow-[0_12px_40px_rgba(229,9,20,0.5)] transition-all duration-300 flex justify-center items-center group transform hover:-translate-y-1">
            Find My Match
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </button>
        
    </form>
    
    <!-- Footer text -->
    {{-- <p class="text-center text-[0.7rem] leading-relaxed text-gray-500 mt-8 max-w-[18rem] mx-auto font-medium">
        CineMatch analyzes over 50,000 titles to find the perfect cinematic experience based on your current vibe.
    </p> --}}

</div>
