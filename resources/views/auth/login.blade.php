@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800 dark:text-white">Welcome</h2>
        <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-5">
            @csrf
            <div id="loginFields">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <input type="email" name="email" id="email" required autofocus 
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white text-base py-2 px-3">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                    <input type="password" name="password" id="password" required 
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white text-base py-2 px-3">
                </div>
                <div id="loginButton" class="flex flex-col space-y-3">
                    <button type="submit" 
                            class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                        Login
                    </button>
                </div>
                <div id="registrationFields" class="fade" style="display: none;">
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" required 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white text-base py-2 px-3">
                    </div>
                    <button type="submit" 
                            class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                        Sign Up
                    </button>
                </div>
            </div>
            <h1 id="toggleText" class="text-center text-sm text-gray-600 dark:text-gray-300">Don't have an account yet? <a href="#" onclick="toggleForm()" class="text-indigo-600 dark:text-indigo-400">Register instead</a></h1>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-auth-compat.js"></script>
<script>
    const firebaseConfig = {
        apiKey: "{{ config('services.firebase.api_key') }}",
        authDomain: "{{ config('services.firebase.auth_domain') }}",
        projectId: "{{ config('services.firebase.project_id') }}",
        storageBucket: "{{ config('services.firebase.storage_bucket') }}",
        messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
        appId: "{{ config('services.firebase.app_id') }}",
        measurementId: "{{ config('services.firebase.measurement_id') }}"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    function signInWithGoogle() {
        const provider = new firebase.auth.GoogleAuthProvider();
        firebase.auth().signInWithPopup(provider)
            .then((idToken) => {
                console.log('ID Token:', idToken); // Log the token for debugging
                return fetch('/firebase-login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ idToken: idToken })
                });
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.message === 'Successfully logged in') {
                    window.location.href = '/';
                } else {
                    throw new Error(data.error || 'Login failed');
                }
            })
            .catch((error) => {
                console.error('Full error object:', error);
                alert('Failed to sign in with Google: ' + (error.error || error.message));
            });
    }

    function toggleForm() {
        const loginFields = document.getElementById('loginFields');
        const registrationFields = document.getElementById('registrationFields');
        const loginButton = document.getElementById('loginButton');
        const toggleText = document.getElementById('toggleText');

        if (registrationFields.style.display === 'none') {
            registrationFields.style.display = 'block';
            setTimeout(() => {
                registrationFields.classList.add('show');
            }, 10);
            loginButton.style.display = 'none';
            toggleText.innerHTML = "Already have an account? <a href='#' onclick='toggleForm()' class='text-indigo-600 dark:text-indigo-400'>Login instead</a>";
        } else {
            registrationFields.classList.remove('show');
            setTimeout(() => {
                registrationFields.style.display = 'none';
            }, 500);
            loginButton.style.display = 'flex';
            toggleText.innerHTML = "Don't have an account yet? <a href='#' onclick='toggleForm()' class='text-indigo-600 dark:text-indigo-400'>Register instead</a>";
        }
    }
</script>
@endsection

<style>
    .fade {
        transition: opacity 0.5s ease, height 0.5s ease, transform 0.5s ease;
        opacity: 0;
        height: 0;
        overflow: hidden;
        transform: scaleY(0);
    }

    .fade.show {
        opacity: 1;
        height: auto;
        transform: scaleY(1);
    }
</style>
