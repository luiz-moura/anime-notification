import { Head } from '@inertiajs/react';
import { toast } from 'react-toastify';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import apiClient from '@/Services/api';
import { getUserToken } from '@/Services/auth';
import StarLogo from '@/Components/StarLogo';
import BookmarkLogo from '@/Components/BookmarkLogo';

export default function Schedule({ auth, animes }) {
    const  handleSubscribe = async (animeSlug) => {
        await apiClient.get(route('anime.subscribe', animeSlug), {
            headers: {
                // authorization: 'Bearer ' + getUserToken()
            }
        }).then(() => {
            toast.success('Anime added to your list')
        }).catch(() => {
            toast.fail('An error occurred while adding anime to your list')
        })
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Schedule</h2>}
        >
            <Head title="Schedule" />

            <section>
                <div className="mx-auto grid max-w-screen-xl grid-cols-1 gap-6 p-6 md:grid-cols-2 lg:grid-cols-3">
                    {animes.map((anime) =>
                        <article className="rounded-xl bg-white p-3 shadow-lg hover:shadow-xl">
                            <a href="#">
                                <div className="relative flex items-end overflow-hidden rounded-xl h-96 bg-violet-400">
                                    <img src={'storage/' + anime.images[0].path} alt={anime.title} className='m-auto' />
                                    <div className="absolute bottom-3 left-3 inline-flex items-center rounded-lg bg-white p-2 shadow-md">
                                        <StarLogo />
                                        <span className="text-slate-400 ml-1 text-sm">4.9</span>
                                    </div>
                                </div>
                                <div className="mt-1 p-2">
                                    <h2 className="text-slate-700">{anime.title}</h2>
                                    <p className="text-slate-400 mt-1 text-sm">
                                        {anime.genres?.map(genre => `${genre.name}, `)}
                                    </p>
                                    <div className="mt-3 flex items-end justify-between">
                                        <p>
                                            <span className="text-slate-400 text-sm">{anime.broadcast?.day ?? '-'} | {anime.broadcast?.time ?? '-'}</span>
                                        </p>
                                        <div className="group inline-flex rounded-xl bg-blue-100 p-2 hover:bg-blue-200" onClick={() => handleSubscribe(anime.slug)}>
                                            <BookmarkLogo />
                                        </div>
                                    </div>
                                    <p className='mt-5'>
                                        {anime.synopsis?.substr(0, 120)}
                                    </p>
                                </div>
                            </a>
                        </article>
                    )}
                </div>
            </section>
        </AuthenticatedLayout>
    )
}
