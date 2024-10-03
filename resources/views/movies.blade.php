<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Streaming</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto mt-10">
        <h1 class="text-4xl font-bold mb-10 text-center">Movie Streaming</h1>

        <!-- TMDb Popular Movies -->
        <h2 class="text-3xl font-bold mb-5">Popular Movies</h2>
        <div class="grid grid-cols-4 gap-6">
            @foreach($tmdbMovies as $movie)
                <div class="border border-gray-700 rounded-lg p-4 hover:shadow-lg transition-shadow movie-item" data-movie-id="{{ $movie['id'] }}">
                    <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}" class="rounded mb-4">
                    <h3 class="text-xl font-semibold">{{ $movie['title'] }}</h3>
                    <p class="text-sm">{{ \Illuminate\Support\Str::limit($movie['overview'], 100) }}</p>
                    <p class="text-gray-400 text-sm mt-2">Release: {{ $movie['release_date'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal for Movie Details -->
    <div id="movieModal" class="fixed inset-0 bg-gray-900 bg-opacity-80 hidden flex items-center justify-center">
        <div class="relative bg-gray-800 rounded-lg p-6 w-full max-w-3xl">
            <h2 id="movieTitle" class="text-3xl font-bold mb-4"></h2>
            <p id="movieOverview" class="mb-4"></p>
            <p><strong>Release Date:</strong> <span id="movieReleaseDate"></span></p>

            <!-- Trailer Video -->
            <div id="trailerSection" class="mt-6 hidden">
                <h3 class="text-2xl mb-3">Trailer</h3>
                <iframe id="movieTrailer" width="100%" height="315" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>

            <!-- Streaming Providers -->
            <div id="streamingSection" class="mt-6 hidden">
                <h3 class="text-2xl mb-3">Available to Stream On</h3>
                <ul id="streamingProviders" class="list-disc ml-5"></ul>
            </div>

            <!-- Close Modal -->
            <button id="closeModal" class="absolute top-2 right-2 text-white bg-red-500 px-2 py-1 rounded">Close</button>
        </div>
    </div>

    <script>
        // Open movie modal on click
        $('.movie-item').on('click', function() {
            var movieId = $(this).data('movie-id');

            // Fetch movie details via AJAX
            $.ajax({
                url: '/movie/' + movieId,
                method: 'GET',
                success: function(data) {
                    var movie = data.details;
                    var trailer = data.trailers.find(trailer => trailer.type === 'Trailer' && trailer.site === 'YouTube');
                    var streamingProviders = data.streamingProviders;

                    // Set movie details in the modal
                    $('#movieTitle').text(movie.title);
                    $('#movieOverview').text(movie.overview);
                    $('#movieReleaseDate').text(movie.release_date);

                    // Display the trailer if available
                    if (trailer) {
                        $('#movieTrailer').attr('src', 'https://www.youtube.com/embed/' + trailer.key);
                        $('#trailerSection').removeClass('hidden');
                    } else {
                        $('#trailerSection').addClass('hidden');
                    }

                    // Display streaming providers
                    if (streamingProviders.length > 0) {
                        $('#streamingProviders').empty();
                        streamingProviders.forEach(provider => {
                            $('#streamingProviders').append(`<li>${provider.provider_name}</li>`);
                        });
                        $('#streamingSection').removeClass('hidden');
                    } else {
                        $('#streamingSection').addClass('hidden');
                    }

                    // Show the modal
                    $('#movieModal').removeClass('hidden');
                }
            });
        });

        // Close movie modal
        $('#closeModal').on('click', function() {
            $('#movieModal').addClass('hidden');
            $('#movieTrailer').attr('src', ''); // Reset trailer URL
        });
    </script>
</body>
</html>
