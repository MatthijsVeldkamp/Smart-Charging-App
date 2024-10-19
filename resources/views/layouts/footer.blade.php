<footer class="bg-white dark:bg-gray-800 text-gray-800 dark:text-white">
  <div class="mx-auto max-w-screen-xl space-y-12 px-4 py-16 sm:px-6 lg:space-y-20 lg:px-8">
    <div class="grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-4">
      <div class="md:col-span-2 lg:col-span-1">
        <div class="text-teal-600 dark:text-teal-300 mb-6">
          <img src="{{ asset('images/Icon logo.png') }}" alt="{{ config('app.name', 'Laravel') }} Logo" class="h-16 w-auto">
        </div>
        <p class="max-w-xs text-gray-700 dark:text-gray-300">
          Korte beschrijving van uw bedrijf of website. Dit kan een slogan of een korte missie zijn.
        </p>
      </div>
      
      <div>
        <p class="font-medium text-gray-900 dark:text-gray-100 text-lg mb-4">Services</p>
        <ul class="space-y-3 text-sm">
          <li><a href="#" class="text-gray-700 dark:text-gray-300 transition hover:opacity-75">1on1 Coaching</a></li>
          <li><a href="#" class="text-gray-700 dark:text-gray-300 transition hover:opacity-75">Company Review</a></li>
          <li><a href="#" class="text-gray-700 dark:text-gray-300 transition hover:opacity-75">Accounts Review</a></li>
          <li><a href="#" class="text-gray-700 dark:text-gray-300 transition hover:opacity-75">HR Consulting</a></li>
          <li><a href="#" class="text-gray-700 dark:text-gray-300 transition hover:opacity-75">SEO Optimisation</a></li>
        </ul>
      </div>

      <div>
        <p class="font-medium text-gray-900 dark:text-gray-100 text-lg mb-4">Bedrijfsinformatie</p>
        <ul class="space-y-3 text-sm">
          <li><a href="{{ route('about') }}" class="text-gray-700 dark:text-gray-300 transition hover:opacity-75">Over</a></li>
        </ul>
      </div>

      <div>
        <p class="font-medium text-gray-900 dark:text-gray-100 text-lg mb-4">Hulpzame links</p>
        <ul class="space-y-3 text-sm">
          <li><a href="{{ route('welcome') }}" class="text-gray-700 dark:text-gray-300 transition hover:opacity-75">Thuispagina</a></li>
          <li><a href="{{ route('dashboard') }}" class="text-gray-700 dark:text-gray-300 transition hover:opacity-75">Dashboard</a></li>
          <li><a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 transition hover:opacity-75">Inlogpagina</a></li>
        </ul>
      </div>
    </div>

    <div class="flex flex-col-reverse gap-4 sm:flex-row sm:items-center sm:justify-between pt-8 border-t border-gray-200 dark:border-gray-700">
      <p class="text-sm text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Alle rechten voorbehouden.</p>

      <ul class="flex justify-start gap-6 sm:justify-end">
        <li>
          <a href="#" rel="noreferrer" target="_blank" class="text-gray-700 dark:text-gray-300 transition hover:opacity-75">
            <span class="sr-only">Facebook</span>
            <svg class="size-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <!-- Facebook icon path -->
            </svg>
          </a>
        </li>
        <!-- Andere sociale media iconen hier -->
      </ul>
    </div>
  </div>
</footer>
