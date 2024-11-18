<?php

namespace App\Http\Controllers;

use App\Models\Socket;
use Illuminate\Http\Request;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class ManageController extends Controller
{
    private $mqtt;
    private $mqttHost;
    private $mqttPort;
    private $mqttUsername;
    private $mqttPassword;
    
    public function __construct()
    {
        $this->mqttHost = env('MQTT_HOST', 'server.byimil.com');
        $this->mqttPort = env('MQTT_PORT', 1883);
        $this->mqttUsername = env('MQTT_USERNAME', 'powerapp');
        $this->mqttPassword = env('MQTT_PASSWORD', 'BeetleFanta24');
    }

    public function index()
    {
        $sockets = Socket::all();
        
        dispatch(function() use ($sockets) {
            try {
                $connectionSettings = (new ConnectionSettings())
                    ->setUsername($this->mqttUsername)
                    ->setPassword($this->mqttPassword)
                    ->setConnectTimeout(2)
                    ->setSocketTimeout(2);

                $mqtt = new MqttClient($this->mqttHost, $this->mqttPort);
                $mqtt->connect($connectionSettings);
                
                foreach ($sockets as $socket) {
                    $mqtt->publish(
                        "cmnd/tasmota_" . $socket->tasmota_id . "/POWER",
                        ""
                    );
                }
                
                $mqtt->disconnect();
            } catch (\Exception $e) {
                \Log::error("MQTT connection error: " . $e->getMessage());
            }
        })->afterResponse();
        
        return view('sockets.index', compact('sockets'));
    }

    public function addSocket(Request $request)
    {
        $validated = $request->validate([
            'tasmota_id' => 'required|string|unique:sockets',
            'name' => 'required|string'
        ]);

        try {
            // Socket eerst opslaan in database
            $socket = Socket::create([
                'tasmota_id' => $validated['tasmota_id'],
                'name' => $validated['name'],
                'status' => 'OFF'  // Standaard status
            ]);

            // Test MQTT verbinding
            $connectionSettings = (new ConnectionSettings())
                ->setUsername($this->mqttUsername)
                ->setPassword($this->mqttPassword)
                ->setConnectTimeout(5)
                ->setSocketTimeout(5);

            $mqtt = new MqttClient($this->mqttHost, $this->mqttPort);
            $mqtt->connect($connectionSettings);
            
            // Vraag initiële status op
            $messageReceived = false;
            
            $mqtt->subscribe(
                "stat/tasmota_" . $socket->tasmota_id . "/POWER",
                function($topic, $message) use ($socket) {
                    \Log::info("Initial status for socket {$socket->tasmota_id}: $message");
                    $socket->status = $message;
                    $socket->save();
                }
            );
            
            // Vraag de status op
            $mqtt->publish(
                "cmnd/tasmota_" . $socket->tasmota_id . "/POWER",
                ""
            );
            
            // Kort wachten op antwoord
            $mqtt->loop(true, true, 0.5);
            
            $mqtt->disconnect();
            
            return redirect()->back()->with('success', 'Socket succesvol toegevoegd!');
        } catch (\Exception $e) {
            \Log::error('Error adding socket: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Kon geen verbinding maken met de socket: ' . $e->getMessage());
        }
    }

    public function toggleSocket($id)
    {
        try {
            $socket = Socket::findOrFail($id);
            $messageReceived = false;
            $newStatus = null;
            
            $connectionSettings = (new ConnectionSettings())
                ->setUsername($this->mqttUsername)
                ->setPassword($this->mqttPassword)
                ->setConnectTimeout(5)
                ->setSocketTimeout(5);

            $mqtt = new MqttClient($this->mqttHost, $this->mqttPort);
            $mqtt->connect($connectionSettings);
            
            // Subscribe eerst op het power topic
            $mqtt->subscribe(
                "stat/tasmota_" . $socket->tasmota_id . "/POWER",
                function($topic, $message) use (&$messageReceived, &$newStatus, $socket) {
                    \Log::info("Received power status: $message");
                    $newStatus = $message;
                    $messageReceived = true;
                }
            );
            
            // Stuur dan pas het TOGGLE commando
            $mqtt->publish(
                "cmnd/tasmota_" . $socket->tasmota_id . "/POWER",
                "TOGGLE"
            );
            
            // Wacht op antwoord
            $startTime = time();
            while (!$messageReceived && (time() - $startTime < 2)) {
                $mqtt->loop(true, true);
                usleep(100000);
            }
            
            $mqtt->disconnect();
            
            if ($messageReceived && $newStatus !== null) {
                $socket->status = $newStatus;
                $socket->save();
                
                return response()->json([
                    'success' => true,
                    'status' => $newStatus,
                    'message' => "Socket status updated to: $newStatus"
                ]);
            }
            
            return response()->json([
                'success' => true,
                'status' => $socket->status
            ]);
            
        } catch (\Exception $e) {
            \Log::error('MQTT toggle error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $socket = Socket::findOrFail($id);
            $socket->delete();
            
            return response()->json(['success' => true, 'message' => 'Socket succesvol verwijderd']);
        } catch (\Exception $e) {
            \Log::error('Socket delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'error' => 'Er ging iets mis bij het verwijderen van de socket: ' . $e->getMessage()
            ]);
        }
    }
}