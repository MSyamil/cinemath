@extends('layouts.app')

@section('bg_class', 'bg-[#0a0a0a]')
@section('hide_overlay', true)

@section('navigation')
    <x-results-nav 
        :w-rating="$w_rating ?? 70" 
        :w-popularity="$w_popularity ?? 30" 
        :comparisonValue="$comparison_value ?? 5"
        :selectedGenre="$selected_genre ?? null"
        :watchedFilter="$watched_filter ?? 'all'"
    />
@endsection

@section('main_padding', 'py-12 px-4 sm:px-6 lg:px-8 mt-4 w-full max-w-[1400px] mx-auto')

@section('content')
<div class="w-full h-full flex flex-col justify-start">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
        <div class="max-w-2xl">
            <h1 class="text-5xl sm:text-6xl font-medium text-white tracking-tight leading-tight mb-4">
                Recommended <br>
                For You.
            </h1>
            <p class="text-[0.95rem] text-gray-400 font-medium leading-relaxed max-w-lg">
                Based on your love for sci-fi thrillers and neon aesthetics. We've analyzed
                4,000+ titles to find your next obsession.
            </p>
        </div>
        <div class="flex-shrink-0">
            <a href="{{ route('movies.export-excel', [
                'comparison_value' => $comparison_value ?? 5,
                'genre' => $selected_genre ?? null,
                'watched_filter' => $watched_filter ?? 'all'
               ]) }}" 
               class="inline-flex items-center gap-2 bg-[#10b981] hover:bg-[#059669] text-white font-semibold py-3 px-6 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9Z" />
                </svg>
                Export to Excel
            </a>
        </div>
    </div>

    <!-- Movie Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
        @foreach($recommendations->take(7) as $movie)
            @php
                $isWatched = isset($watchedMovieIds) && in_array($movie['id'], $watchedMovieIds);
            @endphp
            <x-movie-card :movie="$movie" :isFirst="$loop->first" :isWatched="$isWatched" />
        @endforeach

        <!-- Explore More Card -->
        <div class="group relative flex flex-col h-full min-h-[400px]">
            <div class="relative w-full aspect-[2/3] rounded-2xl overflow-hidden border-2 border-dashed border-gray-700 hover:border-gray-500 bg-gray-900/30 flex flex-col items-center justify-center cursor-pointer transition-all duration-300">
                <div class="p-4 rounded-full bg-white/5 group-hover:bg-white/10 text-gray-400 group-hover:text-white transition-colors duration-300 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-400 group-hover:text-white transition-colors duration-300 tracking-wide">
                    Explore More
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
