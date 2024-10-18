<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 max-w-md mx-auto">
            <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800 dark:text-white">Welcome to Your Dashboard</h2>
            <div class="flex flex-col items-center mb-6">
                <img id="profilePicture" class="w-24 h-24 rounded-full mb-4" src="" alt="Profile Picture">
                <p class="text-gray-700 dark:text-gray-300">Name: <span id="userName" class="font-semibold"></span></p>
                <p class="text-gray-700 dark:text-gray-300">Email: <span id="userEmail" class="font-semibold"></span></p>
            </div>
            <button id="logoutButton" class="w-full py-2 px-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75 transition duration-300 ease-in-out">
                Logout
            </button>
        </div>
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

        firebase.auth().onAuthStateChanged(function(user) {
            if (user) {
                document.getElementById('userName').textContent = user.displayName;
                document.getElementById('userEmail').textContent = user.email;
                document.getElementById('profilePicture').src = user.photoURL || 'https://via.placeholder.com/150';
            } else {
                window.location.href = '/login'; // Redirect to login if not signed in
            }
        });

        document.getElementById('logoutButton').addEventListener('click', function() {
            firebase.auth().signOut().then(function() {
                console.log('Signed Out');
                window.location.href = '/login'; // Redirect to login after logout
            }).catch(function(error) {
                console.error('Sign Out Error', error);
            });
        });

        // Ensure dark mode is applied
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        // Optional: Add a toggle for dark/light mode
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
