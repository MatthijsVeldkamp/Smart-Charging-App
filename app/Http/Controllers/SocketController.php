<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socket;
use App\Models\SmartMeter;
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

        return redirect()->route('sockets')->with('success', 'Socket toegevoegd.');
    }

    public function show(Socket $socket)
    {
        $status = $this->getPowerStatus($socket);
        $measurements = $this->getMeasurements($socket);

        return view('sockets.show', compact('socket', 'status', 'measurements'));
    }

    public function togglePower(Socket $socket)
    {
        $response = Http::get("http://{$socket->ip_address}/cm?cmnd=Power%20TOGGLE");
        
        if ($response->successful()) {
            $newStatus = $this->getPowerStatus($socket);
            return redirect()->route('sockets.show', $socket)->with('status', "Socket is now $newStatus");
        }

        return back()->with('error', 'Failed to toggle power');
    }

    public function getData(Socket $socket)
    {
        return response()->json($this->getMeasurements($socket));
    }

    public function addSmartMeter(Request $request, Socket $socket)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|ip',
        ]);

        $smartMeter = new SmartMeter($validatedData);
        $socket->smartMeter()->save($smartMeter);

        return redirect()->route('sockets', $socket)->with('success', 'Slimme meter toegevoegd.');
    }

    private function getPowerStatus(Socket $socket)
    {
        $response = Http::get("http://{$socket->ip_address}/cm?cmnd=Power");
        
        if ($response->successful()) {
            $data = $response->json();
            return $data['POWER'] ?? 'unknown';
        }

        return 'unknown';
    }

    private function getMeasurements(Socket $socket)
    {
        $response = Http::get("http://{$socket->ip_address}/cm?cmnd=Status%208");
        
        if ($response->successful()) {
            $data = $response->json();
            return [
                'power' => $data['StatusSNS']['ENERGY']['Power'] ?? 'N/A',
                'voltage' => $data['StatusSNS']['ENERGY']['Voltage'] ?? 'N/A',
                'current' => $data['StatusSNS']['ENERGY']['Current'] ?? 'N/A',
                'total_energy' => $data['StatusSNS']['ENERGY']['Total'] ?? 'N/A',
            ];
        }

        return [
            'power' => 'N/A',
            'voltage' => 'N/A',
            'current' => 'N/A',
            'total_energy' => 'N/A',
        ];
    }

    public function destroy(Socket $socket)
    {
        $socket->delete();
        return redirect()->route('sockets')->with('success', 'Socket succesvol verwijderd.');
    }
}
