<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $tmdbService;

    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    // Tampilkan Halaman 1 (Welcome)
    public function index()
    {
        return view('welcome');
    }

    // Proses AHP + SAW lalu tampilkan Halaman 2 (Results)
    public function process(Request $request)
{
    // 1. AMBIL INPUT UI DARI SLIDER (1-9) DAN GENRE
    $nilai_banding = $request->input('comparison_value', 5); 
    $genre_id = $request->input('genre', null);

    // 2. KONVERSI SLIDER UI (1-9) KE SKALA RASIO AHP (1/9 sampai 9)
    // Karena slider UI lurus dari 1 sampai 9, kita translasikan ke matriks matematika AHP:
    // Slider 5 = Seimbang (Ratio 1)
    // Slider 9 = Popularity mutlak (Ratio 9)
    // Slider 1 = Rating mutlak (Ratio 1/9)
    if ($nilai_banding == 5) {
        $ahp_value = 1;
    } elseif ($nilai_banding > 5) {
        $ahp_value = ($nilai_banding - 5) * 2 + 1; // 6->3, 7->5, 8->7, 9->9
    } else {
        $ahp_value = 1 / ((5 - $nilai_banding) * 2 + 1); // 4->1/3, 3->1/5, 2->1/7, 1->1/9
    }

    // 3. HITUNG BOBOT AHP MENGGUNAKAN MATRIKS RASIO YANG BENAR
    $total_kolom1 = 1 + $ahp_value;
    $total_kolom2 = (1/$ahp_value) + 1;

    $w_rating = ((1 / $total_kolom1) + ((1/$ahp_value) / $total_kolom2)) / 2;
    $w_popularity = (($ahp_value / $total_kolom1) + (1 / $total_kolom2)) / 2;

    // 2. OPTIMASI: Tentukan Parameter API berdasarkan Bobot AHP
    $queryParams = [];

    if ($w_rating > 0.6) {
        // Jika user sangat ingin kualitas, filter rating minimal 7.5 dan urutkan dari skor tertinggi
        $queryParams['vote_average.gte'] = 7.5;
        $queryParams['sort_by'] = 'vote_average.desc';
    } elseif ($w_popularity > 0.6) {
        // Jika user mau yang viral, urutkan berdasarkan popularitas tertinggi
        $queryParams['sort_by'] = 'popularity.desc';
    } else {
        // Jika seimbang, ambil yang populer tapi tetap punya rating lumayan
        $queryParams['vote_average.gte'] = 6.0;
        $queryParams['sort_by'] = 'popularity.desc';
    }

    // Jika filter genre dilempar dari dropdown UI, tambahkan ke request API
    if ($genre_id) {
        $queryParams['with_genres'] = $genre_id;
    }

    // 3. KETUK SERVER API (Discovery Mode)
    // Kita ambil 2 halaman (40 film) agar tetap ringan tapi data berkualitas
    $moviesPage1 = $this->tmdbService->discoverMovies(array_merge($queryParams, ['page' => 1]));
    $moviesPage2 = $this->tmdbService->discoverMovies(array_merge($queryParams, ['page' => 2]));
    $allMovies = array_merge($moviesPage1, $moviesPage2);

    // 4. PERHITUNGAN SAW (Sama seperti sebelumnya untuk meranking 40 film tersebut)
    $collection = collect($allMovies);
    $max_rating = $collection->max('vote_average') ?: 1;
    $max_pop = $collection->max('popularity') ?: 1;

    $results = $collection->map(function($movie) use ($max_rating, $max_pop, $w_rating, $w_popularity) {
        $n_rating = $movie['vote_average'] / $max_rating;
        $n_pop = $movie['popularity'] / $max_pop;

        $movie['match_score'] = round((($n_rating * $w_rating) + ($n_pop * $w_popularity)) * 100);
        return $movie;
    })->sortByDesc('match_score');

    // 5. FILTER: SUDAH DITONTON ATAU BELUM
    $watched_filter = $request->input('watched_filter', 'all');
    $watchedMovieIds = [];
    
    if (auth()->check()) {
        $watchedMovieIds = auth()->user()->watchedMovies()->pluck('movie_id')->toArray();
        
        if ($watched_filter === 'watched') {
            $results = $results->filter(function($movie) use ($watchedMovieIds) {
                return in_array($movie['id'], $watchedMovieIds);
            });
        } elseif ($watched_filter === 'unwatched') {
            $results = $results->filter(function($movie) use ($watchedMovieIds) {
                return !in_array($movie['id'], $watchedMovieIds);
            });
        }
    }

    // 6. TERJEMAHKAN SINOPSIS (Hanya 7 Teratas untuk performa)
    $results = $results->values();
    $tr = new \Stichoza\GoogleTranslate\GoogleTranslate('id');

    $results->transform(function ($movie, $key) use ($tr) {
        // Kita hanya menerjemahkan 7 film pertama yang akan ditampilkan di view
        if ($key < 7 && !empty($movie['overview'])) {
            try {
                $movie['overview'] = $tr->translate($movie['overview']);
            } catch (\Exception $e) {
                // Biarkan bahasa asli jika terjemahan gagal
            }
        }
        return $movie;
    });

    return view('results', [
        'recommendations' => $results,
        'w_rating' => round($w_rating * 100),
        'w_popularity' => round($w_popularity * 100),
        'comparison_value' => $nilai_banding,
        'selected_genre' => $genre_id,
        'watched_filter' => $watched_filter,
        'watchedMovieIds' => $watchedMovieIds,
    ]);
}

    // Toggle watched status for a movie
    public function toggleWatched(Request $request, $movie_id)
    {
        $user = auth()->user();
        $watched = $user->watchedMovies()->where('movie_id', $movie_id)->first();

        if ($watched) {
            $watched->delete();
            return response()->json(['status' => 'removed']);
        } else {
            $user->watchedMovies()->create(['movie_id' => $movie_id]);
            return response()->json(['status' => 'added']);
        }
    }
}