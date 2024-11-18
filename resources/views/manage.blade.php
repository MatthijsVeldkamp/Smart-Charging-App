@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6">Beheer</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Sockets</h2>
            <!-- Voeg hier de inhoud voor sockets beheer toe -->
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Locaties</h2>
            <!-- Voeg hier de inhoud voor locaties beheer toe -->
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Facturen</h2>
            <!-- Voeg hier de inhoud voor facturen beheer toe -->
        </div>
    </div>
</div>
@endsection
