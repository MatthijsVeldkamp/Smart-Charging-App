@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 max-w-md mx-auto">
        <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800 dark:text-white">Welcome to Your Dashboard</h2>
        <div class="flex flex-col items-center mb-6">
            <img id="profilePicture" class="w-24 h-24 rounded-full mb-4" src="{{ Auth::user()->profile_photo_url }}" alt="Profile Picture">
            <p class="text-gray-700 dark:text-gray-300">Name: <span id="userName" class="font-semibold"></span></p>
            <p class="text-gray-700 dark:text-gray-300">Email: <span id="userEmail" class="font-semibold"></span></p>
        </div>
        <button id="logoutButton" class="w-full py-2 px-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75 transition duration-300 ease-in-out">
            Logout
        </button>
    </div>
</div>
@endsection

@section('scripts')
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
</script>
@endsection
