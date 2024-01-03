import { onMessage, getToken } from "firebase/messaging"
import { messaging } from "@/utils/initialize"

export const requestPermission = async () => {
    if (Notification.permission === 'default') {
        await Notification.requestPermission()
            .then((status) => {
                if (status == 'granted') {
                    setToken()
                }
            })
    }
}

export const listenToNotifications = () => {
    if (!acceptedNotifications()) {
        return
    }

    onMessage(messaging, function ({ notification }) {
        new Notification(notification.title, {
            body: notification.body,
        })
    })
}

export const setToken = () => {
    getToken(messaging, { vapidKey: 'BPnY0ov0mjBbILlRnhDkKU1ce9J0iYnkFoGpJa8g_tAvejikm3hlc6JLc5SfRzodjdwsaPVPZ8a7ogzKL9EbiFo' })
        .then(token => {
            if (token) {
                navigator.sendBeacon(`/setToken?fcm_token=${token}`)

                return
            }

            toast.warn('Failed to accept notifications, please try again.')
        })
}

export const acceptedNotifications = () => {
    return Notification.permission === 'granted'
}
