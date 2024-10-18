<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- Styles -->
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
        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input {
            margin-bottom: 1rem;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 0.5rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .login-options {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 1rem;
        }
        .google-btn {
            margin-top: 1rem;
            background-color: #fff;
            color: #757575;
            border: 1px solid #ddd;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .google-btn:hover {
            background-color: #f1f1f1;
        }
        .google-btn img {
            width: 18px;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            <input type="email" name="email" id="email" placeholder="Email" required autofocus>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <div class="login-options">
                <button type="submit">Login</button>
                <button type="button" class="google-btn" id="googleSignIn">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google logo">
                    Sign in with Google
                </button>
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
            var provider = new firebase.auth.GoogleAuthProvider();
            firebase.auth().signInWithPopup(provider).then(function(result) {
                var user = result.user;
                console.log(user);
                window.location.href = '/dashboard'; // Redirect to dashboard
            }).catch(function(error) {
                console.error(error);
                alert('Failed to sign in with Google: ' + error.message);
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
    </script>
</body>
</html>
