import { onMessage, getToken } from "firebase/messaging"
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
        if (status !== notificationStatus.granted) {
            throw new PushNotificationError('Rejected notifications, you can activate at any time through settings.')
        }

        const tokenDefined = setToken()

        if (!tokenDefined) {
            throw new PushNotificationError('Failed to set notification token, please try again.')
        }
    }).catch((e) => {
        if (e instanceof PushNotificationError) {
            throw e
        }

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

export const acceptedNotifications = () => {
    return Notification.permission === notificationStatus.granted
}

const setToken = () => {
    getToken(messaging, { vapidKey: import.meta.env.VAPID_KEY }).then(token => {
        navigator.sendBeacon(`/setToken?fcm_token=${token}`)
    }).catch(() => {
        return false
    })

    return true
}

const didntAcceptNotifications = () => {
    return !acceptedNotifications()
}

const doesntSupportNotifications = () => {
    if (!('Notification' in window)) {
        return true
    }

    return false
}
