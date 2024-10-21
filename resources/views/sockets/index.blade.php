@extends('layouts.app')

@section('content')
<div x-data="{ showDeleteModal: false, socketToDelete: null }" class="container mx-auto px-4 py-8">
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
                        <button @click="showDeleteModal = true; socketToDelete = {{ $socket->id }}" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">Verwijderen</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showDeleteModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Socket Verwijderen</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Weet je zeker dat je deze socket wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <form :action="'/sockets/' + socketToDelete" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Verwijderen</button>
                        </form>
                        <button @click="showDeleteModal = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-50 sm:mt-0 sm:w-auto">Annuleren</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
