importScripts("https://www.gstatic.com/firebasejs/10.0.0/firebase-app-compat.js");
importScripts("https://www.gstatic.com/firebasejs/10.0.0/firebase-messaging-compat.js");

firebase.initializeApp({
    apiKey: "AIzaSyC4xeZ8DoFwO3uPF_Fci3RLV6AsIGMaAmQ",
    authDomain: "anime-push-notification.firebaseapp.com",
    projectId: "anime-push-notification",
    storageBucket: "anime-push-notification.appspot.com",
    messagingSenderId: "337882491313",
    appId: "1:337882491313:web:2b18ca16ce21a7c0d2b590",
    measurementId: "G-VHR9S7KRPJ"
});

const messaging = firebase.messaging();
