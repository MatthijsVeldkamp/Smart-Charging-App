@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Grafiek 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Grafiek 1</h2>
            <div class="aspect-w-16 aspect-h-9 bg-gray-200 dark:bg-gray-700 rounded">
                <!-- Hier komt de eerste grafiek -->
            </div>
        </div>

        <!-- Grafiek 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Grafiek 2</h2>
            <div class="aspect-w-16 aspect-h-9 bg-gray-200 dark:bg-gray-700 rounded">
                <!-- Hier komt de tweede grafiek -->
            </div>
        </div>

        <!-- Grafiek 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Grafiek 3</h2>
            <div class="aspect-w-16 aspect-h-9 bg-gray-200 dark:bg-gray-700 rounded">
                <!-- Hier komt de derde grafiek -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Add these script tags to include Firebase SDK -->
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>

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

    // Function to update user info
    function updateUserInfo(user) {
        console.log('Updating user info:', user);
        
        document.getElementById('userName').textContent = user.displayName || '{{ Auth::user()->name }}';
        document.getElementById('userEmail').textContent = user.email || '{{ Auth::user()->email }}';
        
        let photoURL = user.photoURL || '{{ Auth::user()->profile_picture }}' || '{{ Auth::user()->google_avatar }}' || 'https://via.placeholder.com/150';
        let source = 'Default';

        if (user.photoURL) {
            source = 'Firebase';
        } else if ('{{ Auth::user()->profile_picture }}') {
            source = 'Laravel Profile';
        } else if ('{{ Auth::user()->google_avatar }}') {
            source = 'Google Avatar';
        }

        document.getElementById('profilePicture').src = photoURL;
        document.getElementById('pictureSource').textContent = source;

        console.log('Profile picture URL:', photoURL);
        console.log('Profile picture source:', source);
    }

    firebase.auth().onAuthStateChanged(function(user) {
        console.log('Firebase Auth State Changed:', user);
        if (user) {
            updateUserInfo(user);
        } else {
            console.log('No user signed in, redirecting to login');
            window.location.href = '/login';
        }
    });

    document.getElementById('logoutButton').addEventListener('click', function() {
        firebase.auth().signOut().then(function() {
            console.log('Signed Out');
            window.location.href = '/login';
        }).catch(function(error) {
            console.error('Sign Out Error', error);
        });
    });

    // Immediate check for profile picture
    window.addEventListener('load', function() {
        const img = document.getElementById('profilePicture');
        console.log('Initial profile picture src:', img.src);
        img.onerror = function() {
            console.error('Failed to load profile picture:', this.src);
            this.src = 'https://via.placeholder.com/150';
        };
    });
</script>
@endsection
