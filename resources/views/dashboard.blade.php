@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Totaal Energieverbruik</h2>
            @if($connectedSockets > 0)
                <canvas id="energyChart"></canvas>
            @else
                <p class="text-red-500 text-center">Geen verbinding met slimme meters</p>
            @endif
        </div>
        <!-- Andere grafieken hier -->
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($connectedSockets > 0)
        var ctx = document.getElementById('energyChart').getContext('2d');
        var totalEnergy = {{ $totalEnergy }};

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Totaal Energieverbruik'],
                datasets: [{
                    data: [totalEnergy],
                    backgroundColor: ['rgba(75, 192, 192, 0.6)'],
                    borderColor: ['rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Totaal Energieverbruik (kWh)'
                    }
                }
            }
        });
    @endif
});
</script>
@endpush
