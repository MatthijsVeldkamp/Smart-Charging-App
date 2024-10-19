<header class="bg-white dark:bg-gray-800 shadow">
    <nav class="container mx-auto px-6 py-3">
        <div class="flex justify-between items-center">
            <div>
                <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-800 dark:text-white">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>
            <div class="flex items-center">
                @auth
                    <span class="text-gray-600 dark:text-gray-300 mr-4">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400 mr-4">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>
</header>
