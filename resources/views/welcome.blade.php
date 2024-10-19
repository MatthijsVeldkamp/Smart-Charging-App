@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
    <h1 class="text-5xl font-bold mb-8 text-gray-800 dark:text-white">Welcome to {{ config('app.name', 'Laravel') }}</h1>
    <p class="text-xl mb-8 text-gray-600 dark:text-gray-300">Your application tagline or description goes here.</p>
</div>
@endsection
