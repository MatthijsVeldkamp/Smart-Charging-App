<?php

use App\Http\Controllers\Auth\FirebaseAuthController;

Route::post('/firebase-login', [FirebaseAuthController::class, 'login']);
