@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" 
     x-data="{ 
         showDeleteModal: false, 
         socketToDelete: null,
         deleteSocket(socketId) {
             fetch(`/sockets/${socketId}`, {
                 method: 'DELETE',
                 headers: {
                     'X-CSRF-TOKEN': '{{ csrf_token() }}',
                     'Accept': 'application/json',
                     'Content-Type': 'application/json'
                 }
             })
             .then(response => {
                 if (!response.ok) {
                     return response.json().then(err => Promise.reject(err));
                 }
                 return response.json();
             })
             .then(data => {
                 if (data.success) {
                     window.location.reload();
                 } else {
                     throw new Error(data.error || 'Er ging iets mis bij het verwijderen van de socket');
                 }
             })
             .catch(error => {
                 console.error('Error:', error);
                 alert(error.error || 'Er ging iets mis bij het verwijderen van de socket');
             })
             .finally(() => {
                 this.showDeleteModal = false;
             });
         }
     }">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Beheer Sockets</h2>

    <!-- Formulier voor nieuwe socket -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                Nieuwe Socket Toevoegen
            </h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <form method="POST" action="{{ route('sockets.add') }}">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="tasmota_id" class="block text-sm font-medium text-gray-700">
                            Tasmota ID
                        </label>
                        <input type="text" 
                               id="tasmota_id" 
                               name="tasmota_id" 
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Naam
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Toevoegen
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Lijst van bestaande sockets -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                Geïnstalleerde Sockets
            </h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Naam
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tasmota ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acties
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($sockets as $socket)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $socket->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $socket->tasmota_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="status-badge px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $socket->status === 'ON' 
                                        ? 'bg-green-100 text-green-800' 
                                        : 'bg-red-100 text-red-800' }}">
                                    {{ $socket->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <button class="toggle-socket inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        data-socket-id="{{ $socket->id }}">
                                    Aan/Uit
                                </button>
                                <button @click="socketToDelete = {{ $socket->id }}; showDeleteModal = true" 
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Verwijderen
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
                     class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                     @click.away="showDeleteModal = false">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                                    Socket Verwijderen
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Weet je zeker dat je deze socket wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button"
                                @click="deleteSocket(socketToDelete)"
                                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                            Verwijderen
                        </button>
                        <button type="button"
                                @click="showDeleteModal = false"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Annuleren
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.toggle-socket').forEach(button => {
    button.addEventListener('click', function() {
        const socketId = this.dataset.socketId;
        const button = this;
        const statusSpan = button.closest('tr').querySelector('.status-badge');
        
        button.disabled = true;
        button.classList.add('opacity-75');
        
        fetch(`/sockets/${socketId}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                throw new Error(data.error);
            }
            
            // Update status badge
            if (data.status === 'ON') {
                statusSpan.classList.remove('bg-red-100', 'text-red-800');
                statusSpan.classList.add('bg-green-100', 'text-green-800');
            } else {
                statusSpan.classList.remove('bg-green-100', 'text-green-800');
                statusSpan.classList.add('bg-red-100', 'text-red-800');
            }
            statusSpan.textContent = data.status;
            
            // Success feedback
            button.classList.add('bg-green-600');
            setTimeout(() => {
                button.classList.remove('bg-green-600');
            }, 1000);
        })
        .catch(error => {
            button.classList.add('bg-red-600');
            setTimeout(() => {
                button.classList.remove('bg-red-600');
            }, 1000);
            console.error('Error:', error);
            alert('Er ging iets mis: ' + error.message);
        })
        .finally(() => {
            button.disabled = false;
            button.classList.remove('opacity-75');
        });
    });
});

// Vervang het bestaande setInterval met dit:
// Check vaker in het begin, daarna minder frequent
let checkCount = 0;
const maxChecks = 5;

function checkStatuses() {
    fetch(window.location.href)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Update alle status badges
            document.querySelectorAll('.status-badge').forEach(badge => {
                const socketId = badge.closest('tr').querySelector('.toggle-socket').dataset.socketId;
                const newBadge = doc.querySelector(`[data-socket-id="${socketId}"]`)
                    .closest('tr')
                    .querySelector('.status-badge');
                
                badge.className = newBadge.className;
                badge.textContent = newBadge.textContent;
            });
            
            checkCount++;
            if (checkCount < maxChecks) {
                // Check snel in het begin (elke 2 seconden)
                setTimeout(checkStatuses, 2000);
            } else {
                // Daarna elke 30 seconden
                setTimeout(checkStatuses, 30000);
            }
        });
}

// Start de eerste check na 1 seconde
setTimeout(checkStatuses, 1000);
</script>
@endsection