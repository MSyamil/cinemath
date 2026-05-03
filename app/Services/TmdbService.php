<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TmdbService
{
    // Method baru untuk pencarian cerdas
    public function discoverMovies($params = [])
    {
        $defaultParams = [
            'api_key' => config('services.tmdb.key'),
            'language' => 'en-US',
            'page' => 1,
            'include_adult' => false,
        ];

        // Menggabungkan parameter default dengan filter dari AHP
        $finalParams = array_merge($defaultParams, $params);

        $response = Http::get(config('services.tmdb.base_url') . '/discover/movie', $finalParams);

        return $response->json()['results'];
    }
}