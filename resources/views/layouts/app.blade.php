<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <nav class="bg-blue-600 p-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Logo -->
            <div class="text-white text-2xl font-semibold">Laravel Test Books</div>

            <!-- Menu for larger screens -->
            <div class="hidden md:flex space-x-6">
                <a href="/" class="text-white hover:text-gray-200 hover:border-red-600 @if ($title === "Author") border-b-2 border-white-800 @endif">Author</a>
                <a href="{{ route('books.index') }}" class="text-white hover:text-gray-200 hover:border-red-600 @if ($title === "Book") border-b-2 border-white-800 @endif">Book</a>
            </div>

            <!-- Hamburger Menu (for smaller screens) -->
            <div class="md:hidden flex items-center">
                <button id="menu-toggle" class="text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden text-white space-y-4 p-4 mt-4">
            <a href="/" class="block hover:text-gray-200 text-center @if ($title === "Author") rounded-md bg-gray-800 @endif">Author</a>
            <a href="{{ route('books.index') }}" class=" text-center block hover:text-gray-200 @if ($title === "Book") rounded-md bg-gray-800 @endif">Book</a>
        </div>
    </nav>

    <section class="w-full mt-3 mx-auto max-w-screen-lg px-4">
        @yield('content')
    </section>

    <script>
        // Toggle mobile menu visibility
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</html>
