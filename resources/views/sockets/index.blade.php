@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white">Sockets Beheer</h1>

    <div class="mb-8 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Voeg Nieuwe Socket Toe</h2>
        <form action="{{ route('sockets.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Naam</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label for="ip_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">IP Adres</label>
                <input type="text" name="ip_address" id="ip_address" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-100 dark:bg-blue-500 text-blue-700 dark:text-white rounded-md border border-blue-300 dark:border-blue-600 hover:bg-blue-200 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors duration-300 shadow-sm">
                Toevoegen
            </button>
        </form>
    </div>

    <div>
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Bestaande Sockets</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($sockets as $socket)
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-white">{{ $socket->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">IP: {{ $socket->ip_address }}</p>
                    <div class="flex space-x-4">
                        <form action="{{ route('sockets.toggle', $socket) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Aan/Uit</button>
                        </form>
                        <a href="{{ route('sockets.show', $socket) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Details</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
