import { initializeApp } from 'firebase/app'
import { getMessaging } from "firebase/messaging"

const firebaseConfig = {
    apiKey: "AIzaSyC4xeZ8DoFwO3uPF_Fci3RLV6AsIGMaAmQ",
    authDomain: "anime-push-notification.firebaseapp.com",
    projectId: "anime-push-notification",
    storageBucket: "anime-push-notification.appspot.com",
    messagingSenderId: "337882491313",
    appId: "1:337882491313:web:2b18ca16ce21a7c0d2b590",
    measurementId: "G-VHR9S7KRPJ"
}

export const app = initializeApp(firebaseConfig)
export const messaging = getMessaging(app)
