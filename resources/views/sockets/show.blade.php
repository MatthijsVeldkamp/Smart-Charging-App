@extends('layouts.app')

@section('content')
<div x-data="{ showDeleteModal: false }" class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white">Socket Details: {{ $socket->name }}</h1>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Socket Informatie</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-2">Naam: {{ $socket->name }}</p>
        <p class="text-gray-600 dark:text-gray-400 mb-4">IP Adres: {{ $socket->ip_address }}</p>
        
        <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-white">Status</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-4">Huidige status: <span id="status" class="font-bold">{{ $status }}</span></p>
        
        <form action="{{ route('sockets.toggle', $socket) }}" method="POST" class="mb-4">
            @csrf
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Toggle Aan/Uit
            </button>
        </form>

        <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-white">Metingen</h3>
        <div id="measurements">
            <p class="text-gray-600 dark:text-gray-400">Vermogen: <span id="power">{{ $measurements['power'] }} W</span></p>
            <p class="text-gray-600 dark:text-gray-400">Spanning: <span id="voltage">{{ $measurements['voltage'] }} V</span></p>
            <p class="text-gray-600 dark:text-gray-400">Stroom: <span id="current">{{ $measurements['current'] }} A</span></p>
            <p class="text-gray-600 dark:text-gray-400">Totaal Energieverbruik: <span id="total_energy">{{ $measurements['total_energy'] }} kWh</span></p>
        </div>

        <button id="refreshData" class="mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
            Ververs Gegevens
        </button>

        <button @click="showDeleteModal = true" class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
            Verwijder Socket
        </button>
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
                                    <p class="text-lg text-gray-500">Weet u zeker dat u de socket: "{{ $socket->name }}" wilt verwijderen?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <form action="{{ route('sockets.destroy', $socket) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Verwijderen</button>
                        </form>
                        <button @click="showDeleteModal = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Annuleren</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('refreshData').addEventListener('click', function() {
    fetch('{{ route('sockets.data', $socket) }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('power').textContent = data.power + ' W';
            document.getElementById('voltage').textContent = data.voltage + ' V';
            document.getElementById('current').textContent = data.current + ' A';
            document.getElementById('total_energy').textContent = data.total_energy + ' kWh';
        });
});
</script>
@endsection
