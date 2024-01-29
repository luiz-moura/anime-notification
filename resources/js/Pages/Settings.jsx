import { Head } from "@inertiajs/react"
import { useEffect, useState } from "react";

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { didntAcceptNotifications, requestPermission, removeToken } from "@/Services/notification";
import { toast } from "react-toastify";
import Cookies from "js-cookie";

export default function Settings({ auth }) {
    const [notificationsOn, setNotificationsOn] = useState(true)

    useEffect(() => {
        setNotificationsOn(Cookies.get('notification') === 'granted')

        if (didntAcceptNotifications() && notificationsOn) {
            removeToken()
            setNotificationsOn(false)
        }
    }, [])

    useEffect(() => {
        Cookies.set('notification', notificationsOn ? 'granted' : 'removed')
    }, [notificationsOn])

    const handlePermission = async () =>  {
        if (notificationsOn) {
            removeToken()
            setNotificationsOn(false)
            toast.success('Notifications disabled successfully')

            return
        }

        requestPermission().then(() => {
            if (didntAcceptNotifications()) {
                toast.warn('Rejected notifications, you can activate at any time through settings.')
                setNotificationsOn(false)

                return
            }

            toast.success('Notifications activated successfully')
            setNotificationsOn(true)
        }).catch(() => toast.error(e.message))
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-slate-50 leading-tight">Dashboard</h2>}
        >
            <Head title="Settings" />

            <div className="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                <div className="form-control">
                    <label className="cursor-pointer label">
                        <span className="label-text">Receive notifications</span>
                        <input
                            type="checkbox"
                            className="checkbox checkbox-error"
                            onChange={handlePermission}
                            checked={notificationsOn ? 'checked' : ''}
                        />
                    </label>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
