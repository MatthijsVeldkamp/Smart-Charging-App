@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6">Gegevens voor {{ $socket->name }}</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Huidige Metingen</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="font-medium">Vermogen:</p>
                <p>{{ $data['StatusSNS']['ENERGY']['Power'] ?? 'N/A' }} W</p>
            </div>
            <div>
                <p class="font-medium">Spanning:</p>
                <p>{{ $data['StatusSNS']['ENERGY']['Voltage'] ?? 'N/A' }} V</p>
            </div>
            <div>
                <p class="font-medium">Stroom:</p>
                <p>{{ $data['StatusSNS']['ENERGY']['Current'] ?? 'N/A' }} A</p>
            </div>
            <div>
                <p class="font-medium">Totaal Verbruik:</p>
                <p>{{ $data['StatusSNS']['ENERGY']['Total'] ?? 'N/A' }} kWh</p>
            </div>
        </div>
    </div>
</div>
@endsection
