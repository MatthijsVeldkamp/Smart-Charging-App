@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
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

        <form action="{{ route('sockets.destroy', $socket) }}" method="POST" class="mt-4" onsubmit="return confirm('Weet je zeker dat je deze socket wilt verwijderen?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                Verwijder Socket
            </button>
        </form>
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
