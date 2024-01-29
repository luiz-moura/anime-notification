import { Head } from '@inertiajs/react';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Dashboard({ auth }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-slate-50 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            <div className="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                <div className="bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <div className="p-6 text-slate-400">You're logged in!</div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
