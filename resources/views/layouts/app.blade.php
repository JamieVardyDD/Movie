<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Streaming App</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-900 text-white">

    <!-- App Bar -->
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="/" class="text-2xl font-bold text-white">MovieStream</a>

            <!-- Navigation Links -->
            <div class="flex space-x-6">
                <a href="/" class="text-lg text-gray-300 hover:text-white">Popular Movies</a>
                <a href="/favorites" class="text-lg text-gray-300 hover:text-white">Favorite Movies</a>
                <a href="/new-releases" class="text-lg text-gray-300 hover:text-white">New Releases</a>
            </div>

            <!-- Search Bar -->
            <div class="flex items-center space-x-4">
                <input type="text" id="searchBar" class="w-64 px-4 py-2 rounded-md bg-gray-700 text-gray-200 focus:outline-none" placeholder="Search movies...">
                <button id="searchButton" class="bg-blue-500 px-4 py-2 rounded-md text-white hover:bg-blue-600">Search</button>
            </div>

            <!-- Account Dropdown -->
            <div class="relative">
                <button id="accountDropdownButton" class="flex items-center space-x-2 bg-gray-700 px-4 py-2 rounded-md">
                    <span class="text-gray-200">Account</span>
                    <svg class="w-4 h-4 text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <!-- Dropdown Menu -->
                <div id="accountDropdownMenu" class="absolute right-0 mt-2 w-48 bg-gray-700 rounded-md shadow-lg hidden">
                    <a href="/profile" class="block px-4 py-2 text-gray-200 hover:bg-gray-600">Profile</a>
                    <a href="/logout" class="block px-4 py-2 text-gray-200 hover:bg-gray-600">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-10">
        @yield('content')
    </div>

    <script>
        // Toggle Account Dropdown
        $('#accountDropdownButton').on('click', function() {
            $('#accountDropdownMenu').toggleClass('hidden');
        });

        // Search Functionality (This can be extended in the controller)
        $('#searchButton').on('click', function() {
            const query = $('#searchBar').val();
            if (query) {
                window.location.href = `/search?query=${query}`;
            }
        });
    </script>

</body>
</html>
