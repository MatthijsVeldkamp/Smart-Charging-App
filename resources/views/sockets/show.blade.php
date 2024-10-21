@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white">Socket Details: {{ $socket->name }}</h1>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Socket Informatie</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-2">Naam: {{ $socket->name }}</p>
        <p class="text-gray-600 dark:text-gray-400 mb-4">IP Adres: {{ $socket->ip_address }}</p>
        
        @if($socket->smartMeter)
            <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-white">Slimme Meter</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-2">Naam: {{ $socket->smartMeter->name }}</p>
            <p class="text-gray-600 dark:text-gray-400 mb-2">IP Adres: {{ $socket->smartMeter->ip_address }}</p>
        @else
            <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-white">Voeg Slimme Meter Toe</h3>
            <form action="{{ route('sockets.addSmartMeter', $socket) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Naam</label>
                    <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="ip_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">IP Adres</label>
                    <input type="text" name="ip_address" id="ip_address" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Slimme Meter Toevoegen</button>
            </form>
        @endif
    </div>
</div>
@endsection