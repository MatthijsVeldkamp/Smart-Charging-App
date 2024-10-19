<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Illuminate\Support\Facades\Log;

class FirebaseAuthController extends Controller
{
    protected $auth;

    public function __construct()
    {
        try {
            $credentialsPath = storage_path('app/firebase/firebase_credentials.json');
            if (!file_exists($credentialsPath)) {
                throw new \Exception('Firebase credentials file not found');
            }
            if (filesize($credentialsPath) === 0) {
                throw new \Exception('Firebase credentials file is empty');
            }
            $this->auth = (new Factory)
                ->withServiceAccount($credentialsPath)
                ->createAuth();
        } catch (\Exception $e) {
            Log::error('Firebase initialization error: ' . $e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $idToken = $request->input('idToken');

        try {
            if (!$this->auth) {
                throw new \Exception('Firebase Auth not initialized');
            }

            // Add clock skew tolerance (e.g., 5 minutes)
            $verifiedIdToken = $this->auth->verifyIdToken($idToken, false, 300);
            $uid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');
            $name = $verifiedIdToken->claims()->get('name');

            // Find or create the user
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => bcrypt(rand(100000, 999999))]
            );

            // Log the user in
            Auth::login($user);

            return response()->json(['message' => 'Successfully logged in']);
        } catch (FailedToVerifyToken $e) {
            Log::error('Failed to verify token: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid token: ' . $e->getMessage()], 401);
        } catch (\Exception $e) {
            Log::error('Firebase Auth Error: ' . $e->getMessage());
            return response()->json(['error' => 'Authentication failed: ' . $e->getMessage()], 500);
        }
    }
}
