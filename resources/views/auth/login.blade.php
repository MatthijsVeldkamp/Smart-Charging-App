@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800 dark:text-white">Welcome</h2>
        <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-5">
            @csrf
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
            <div class="flex flex-col space-y-3">
                <button type="submit" 
                        class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                    Login
                </button>
                <button type="button" onclick="signInWithGoogle()"
                        class="w-full py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-base font-medium text-gray-700 dark:text-white bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center justify-center">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google logo" class="w-5 h-5 mr-2">
                    Sign in with Google
                </button>
                <div id="googleLoader" class="loader" style="display: none;"></div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-auth-compat.js"></script>
<script>
    const firebaseConfig = {
        apiKey: "AIzaSyB3IQx0Wo1otQj6p1p3UxzxnDerzF73bcg",
        authDomain: "fiets-laadpaal-59d4a.firebaseapp.com",
        projectId: "fiets-laadpaal-59d4a",
        storageBucket: "fiets-laadpaal-59d4a.appspot.com",
        messagingSenderId: "169148185400",
        appId: "1:169148185400:web:356ec740a45a1ef39ddfcd",
        measurementId: "G-7V11X159EJ"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    function signInWithGoogle() {
        const provider = new firebase.auth.GoogleAuthProvider();
        firebase.auth().signInWithPopup(provider)
            .then((result) => {
                const user = result.user;
                return user.getIdToken();
            })
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
</script>
@endsection
