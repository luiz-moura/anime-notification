import { Head } from "@inertiajs/react"
import { useEffect, useState } from "react";

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { acceptedNotifications, requestPermission } from "@/Services/notification";
import { toast } from "react-toastify";

export default function Settings({ auth }) {
    const [notification, setNotification] = useState(false)

    const handlePermission = async () =>  {
        try {
            await requestPermission()
        } catch (e) {
            toast.error('😔 ' + e.message)
        }

        if (acceptedNotifications()) {
            toast.success('😁 Notifications activated successfully')
            setNotification(true)
        }
    }

    useEffect(() => {
        setNotification(acceptedNotifications())
    }, [])

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Settings" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="form-control">
                        <label className="cursor-pointer label">
                            <span className="label-text">Receive notifications</span>
                            <input
                                type="checkbox"
                                className="checkbox checkbox-warning"
                                onChange={handlePermission}
                                checked={notification ? 'checked' : ''}
                            />
                        </label>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
