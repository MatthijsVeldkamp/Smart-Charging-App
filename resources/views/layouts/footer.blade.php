<footer class="bg-white dark:bg-gray-800">
    <div class="max-w-screen-xl px-4 py-12 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8">
        <div class="text-teal-600 dark:text-teal-300 mb-6 flex justify-center">
            <img src="{{ asset('images/Icon logo.png') }}" alt="{{ config('app.name', 'Laravel') }} Logo" class="h-16 w-auto">
        </div>
        
        <p class="text-center max-w-xs mx-auto text-gray-700 dark:text-gray-300">
            EV Service heeft alles in huis voor het laden van elektrische voertuigen.
        </p>

        <nav class="flex flex-wrap justify-center -mx-5 -my-2">
            <div class="px-5 py-2">
                <a href="{{ route('about') }}" class="text-base leading-6 text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                    Over EvService
                </a>
            </div>
            <div class="px-5 py-2">
                <a href="{{ route('about') }}" class="text-base leading-6 text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                    Veel gestelde vragen
                </a>
            </div>
            <div class="px-5 py-2">
                <a href="{{ route('about') }}" class="text-base leading-6 text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                    Terugkoop garantie
                </a>
            </div>
            <div class="px-5 py-2">
                <a href="{{ route('about') }}" class="text-base leading-6 text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                    Retourneren
                </a>
            </div>
            <div class="px-5 py-2">
                <a href="{{ route('about') }}" class="text-base leading-6 text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                    Blog
                </a>
            </div>
            <div class="px-5 py-2">
                <a href="{{ route('about') }}" class="text-base leading-6 text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                    Contact
                </a>
            </div>
        </nav>

        <div class="flex justify-center mt-8 space-x-6">
            <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                <span class="sr-only">Facebook</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                </svg>
            </a>
            <!-- Voeg hier andere sociale media iconen toe zoals in het originele bestand -->
        </div>

        <p class="mt-8 text-base leading-6 text-center text-gray-400">
            &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Alle rechten voorbehouden.
        </p>
    </div>
</footer>
