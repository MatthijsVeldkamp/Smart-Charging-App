<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    @vite('resources/css/app.css')
    <style>
        .loader {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            margin: 10px auto 0;
            display: none;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 h-screen flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800 dark:text-white">Login</h2>
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
                <button type="button" id="googleSignIn"
                        class="w-full py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-base font-medium text-gray-700 dark:text-white bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center justify-center">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google logo" class="w-5 h-5 mr-2">
                    Sign in with Google
                </button>
                <div id="googleLoader" class="loader"></div>
            </div>
        </form>
    </div>

    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-auth-compat.js"></script>

    <script>
        // Your web app's Firebase configuration
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

        document.getElementById('googleSignIn').addEventListener('click', function() {
            document.getElementById('googleLoader').style.display = 'block';
            var provider = new firebase.auth.GoogleAuthProvider();
            firebase.auth().signInWithPopup(provider).then(function(result) {
                var user = result.user;
                console.log(user);
                window.location.href = '/dashboard'; // Redirect to dashboard
            }).catch(function(error) {
                console.error(error);
                alert('Failed to sign in with Google: ' + error.message);
            }).finally(function() {
                document.getElementById('googleLoader').style.display = 'none';
            });
        });

        firebase.auth().onAuthStateChanged(function(user) {
            if (user) {
                console.log('User is signed in');
                window.location.href = '/dashboard'; // Redirect to dashboard if already signed in
            } else {
                console.log('No user is signed in');
            }
        });

        // Add this script to ensure dark mode is applied
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        // Optionally, you can add a toggle for dark/light mode
        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
    </script>
</body>
</html>
