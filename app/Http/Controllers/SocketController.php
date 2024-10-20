<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socket;
use Illuminate\Support\Facades\Http;

class SocketController extends Controller
{
    public function index()
    {
        $sockets = Socket::all();
        return view('sockets.index', compact('sockets'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|ip',
        ]);

        Socket::create($validatedData);

        return redirect()->route('sockets.index')->with('success', 'Socket toegevoegd.');
    }

    public function togglePower(Socket $socket)
    {
        $response = Http::get("http://{$socket->ip_address}/cm?cmnd=Power%20TOGGLE");
        
        if ($response->successful()) {
            return back()->with('success', 'Socket status gewijzigd.');
        }

        return back()->with('error', 'Kon socket status niet wijzigen.');
    }

    public function getData(Socket $socket)
    {
        $response = Http::get("http://{$socket->ip_address}/cm?cmnd=Status%208");
        
        if ($response->successful()) {
            $data = $response->json();
            // Verwerk de gegevens zoals nodig
            return view('sockets.data', compact('socket', 'data'));
        }

        return back()->with('error', 'Kon gegevens niet ophalen.');
    }
}
