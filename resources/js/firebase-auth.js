import { initializeApp } from "firebase/app";
import { getAuth, signInWithPopup, GoogleAuthProvider } from "firebase/auth";
import axios from 'axios';

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
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

window.signInWithGoogle = function() {
    const provider = new GoogleAuthProvider();
    const loader = document.getElementById('googleLoader');
    if (loader) loader.style.display = 'block';

    signInWithPopup(auth, provider)
        .then((result) => {
            const user = result.user;
            return user.getIdToken();
        })
        .then((idToken) => {
            // Send the token to your Laravel backend
            return axios.post('/firebase-login', { idToken }, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
        })
        .then((response) => {
            // Redirect to home page after successful authentication
            window.location.href = '/';
        })
        .catch((error) => {
            console.error(error);
            alert('Failed to sign in with Google: ' + error.message);
        })
        .finally(() => {
            if (loader) loader.style.display = 'none';
        });
}
