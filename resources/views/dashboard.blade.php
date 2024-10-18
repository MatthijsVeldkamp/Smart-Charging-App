<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .dashboard-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 1rem;
        }
        button {
            padding: 0.5rem 1rem;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 1rem;
        }
        button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome to Your Dashboard</h2>
        <img id="profilePicture" class="profile-picture" src="" alt="Profile Picture">
        <p>Name: <span id="userName"></span></p>
        <p>Email: <span id="userEmail"></span></p>
        <button id="logoutButton">Logout</button>
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
                document.getElementById('profilePicture').src = user.photoURL;
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
</body>
</html>
