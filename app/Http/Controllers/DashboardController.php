<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Socket;

class DashboardController extends Controller
{
    public function index()
    {
        $sockets = Socket::all();
        $totalEnergy = 0;
        $connectedSockets = 0;

        foreach ($sockets as $socket) {
            $measurements = $this->getMeasurements($socket);
            if ($measurements['connected']) {
                $totalEnergy += $measurements['total_energy'];
                $connectedSockets++;
            }
        }

        return view('dashboard', compact('sockets', 'totalEnergy', 'connectedSockets'));
    }

    private function getMeasurements(Socket $socket)
    {
        try {
            $response = Http::timeout(5)->get("http://{$socket->ip_address}/cm?cmnd=Status%208");
            
            if ($response->successful()) {
                $data = $response->json();
                return [
                    'connected' => true,
                    'total_energy' => $data['StatusSNS']['ENERGY']['Total'] ?? 0,
                ];
            }
        } catch (\Exception $e) {
            // Verbinding mislukt of timeout
        }

        return ['connected' => false, 'total_energy' => 0];
    }
}
