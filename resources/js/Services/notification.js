import { onMessage, getToken, deleteToken } from "firebase/messaging"
import { messaging } from "@/utils/initialize"
import PushNotificationError from "@/Errors/PushNotificationError"

const notificationStatus = {
    granted: 'granted',
}

export const requestPermission = async () => {
    if (doesntSupportNotifications()) {
        throw new PushNotificationError('This browser does not support desktop notification.')
    }

    await Notification.requestPermission().then((status) => {
        if (status === notificationStatus.granted) {
            setToken()
        }
    }).catch(() => {
        throw new PushNotificationError('An error occurred, please try again')
    })
}

export const listenToNotifications = () => {
    if (doesntSupportNotifications() && didntAcceptNotifications()) {
        return
    }

    onMessage(messaging, function ({ notification }) {
        new Notification(notification.title, {
            body: notification.body,
            image: notification.image,
            lang: 'en'
        })
    })
}

export const removeToken = () => {
    deleteToken(messaging)
}

export const acceptedNotifications = () => {
    return Notification.permission === notificationStatus.granted
}

export const didntAcceptNotifications = () => {
    return !acceptedNotifications()
}

const setToken = async () => {
    await getToken(messaging, {
        vapidKey: import.meta.env.VITE_VAPID_PUBLIC_KEY
    }).then(token => {
        navigator.sendBeacon(`notification/set-token?token=${token}`)
    }).catch(() => {
        throw new PushNotificationError('Failed to set notification token, please try again.')
    })
}

const doesntSupportNotifications = () => {
    if (!('Notification' in window)) {
        return true
    }

    return false
}
