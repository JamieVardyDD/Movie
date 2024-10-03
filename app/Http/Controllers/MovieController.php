<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    // Fetch popular movies and local movies
    public function index()
    {
        $response = Http::get('https://api.themoviedb.org/3/movie/popular', [
            'api_key' => env('TMDB_API_KEY'),
        ]);
        $tmdbMovies = $response->json()['results'];

        return view('movies', compact('tmdbMovies'));
    }

    // Fetch movie details, trailer, and streaming providers
    public function getMovieDetails($id)
    {
        $apiKey = env('TMDB_API_KEY');

        // Fetch movie details
        $detailsResponse = Http::get("https://api.themoviedb.org/3/movie/{$id}", [
            'api_key' => $apiKey,
        ]);
        $movieDetails = $detailsResponse->json();

        // Fetch movie trailers
        $trailerResponse = Http::get("https://api.themoviedb.org/3/movie/{$id}/videos", [
            'api_key' => $apiKey,
        ]);
        $trailers = $trailerResponse->json()['results'];

        // Fetch movie streaming providers
        $streamingResponse = Http::get("https://api.themoviedb.org/3/movie/{$id}/watch/providers", [
            'api_key' => $apiKey,
        ]);
        $streamingProviders = $streamingResponse->json()['results']['US'] ?? []; // Change 'US' to your target region

        return response()->json([
            'details' => $movieDetails,
            'trailers' => $trailers,
            'streamingProviders' => $streamingProviders['flatrate'] ?? [], // Get flat-rate providers
        ]);
    }
}
