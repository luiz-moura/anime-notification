import { Head } from '@inertiajs/react';
import { toast } from 'react-toastify';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import apiClient from '@/Services/api';
import StarLogo from '@/Components/StarLogo';
import BookmarkLogo from '@/Components/BookmarkLogo';
import { useEffect, useState } from 'react';

export default function Schedule({ auth, animeSchedule, subscriptions }) {
    const [subs, setSubs] = useState([])

    const  handleSubscribe = async (animeId) => {
        const isSubscribed = !!subs.find(sub => sub.anime_id == animeId)
        if (isSubscribed) {
            unsubscribe(animeId)

            return;
        }

        subscribe(animeId)
    }

    const unsubscribe = async (animeId) => {
        await apiClient.get(route('anime.unsubscribe', animeId)).then(() => {
            toast.success('Anime removed from your list')
            setSubs(subs.filter(sub => sub.anime_id != animeId))
        }).catch(() => {
            toast.fail('An error occurred while removing anime from your list')
        })
    }

    const subscribe = async (animeId) => {
        await apiClient.get(route('anime.subscribe', animeId)).then(() => {
            toast.success('Anime added to your list')
            setSubs([...subs, { anime_id: animeId, type: 'watching' }])
        }).catch(() => {
            toast.fail('An error occurred while adding anime to your list')
        })
    }

    useEffect(() => {
        setSubs(subscriptions)
    }, [])

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-slate-50 leading-tight">Schedule</h2>}
        >
            <Head title="Schedule" />

            <section className='max-w-screen-2xl mx-auto'>
                {Object.entries(animeSchedule).map(([ day, animesOfTheDay ]) =>
                    <div key={day}>
                        <h1 className='px-4 sm:px-6 lg:px-8'>
                            <div class="divider divider-start divider-error">{day.toUpperCase()}</div>
                        </h1>
                        <div className="grid grid-cols-1 gap-6 p-6 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
                            {animesOfTheDay.map((anime) => (
                                <article className="rounded-xl bg-zinc-900 p-3 shadow-lg hover:shadow-xl" key={anime.id}>
                                    <div className="relative flex items-end overflow-hidden rounded-xl h-96 bg-red-900">
                                        <img src={'storage/' + anime.images[0].path} alt={anime.title} className='m-auto' />
                                        <div className="absolute bottom-3 left-3 inline-flex items-center rounded-lg bg-zinc-900 p-2 shadow-md">
                                            <StarLogo />
                                            <span className="text-slate-400 ml-1 text-sm">4.9</span>
                                        </div>
                                    </div>
                                    <div className="mt-1 p-2">
                                        <h2 className="text-slate-50 mb-2">{anime.title}</h2>
                                        <p className="text-slate-400 text-sm">
                                            {anime.genres?.map(genre => genre.name).join(', ')}
                                        </p>
                                        <div className="mt-3 flex items-end justify-between">
                                            <p>
                                                <span className="text-slate-400 text-sm">{anime.broadcast?.day ?? '-'} | {anime.broadcast?.time ?? '-'}</span>
                                            </p>
                                            <div className="group inline-flex rounded-xl p-2 hover:bg-zinc-700" onClick={() => handleSubscribe(anime.id)}>
                                                <BookmarkLogo fill={subs.find(sub => sub.anime_id == anime.id) ? '#b91c1c' : '#0a0a0a' } />
                                            </div>
                                        </div>
                                        <p className='mt-5'>
                                            {anime.synopsis?.substr(0, 120)}
                                        </p>
                                    </div>
                                </article>
                            ))}
                        </div>
                    </div>
                )}
            </section>
        </AuthenticatedLayout>
    )
}
