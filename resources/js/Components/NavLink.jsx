import { Link } from '@inertiajs/react';

export default function NavLink({ active = false, className = '', children, ...props }) {
    return (
        <Link
            {...props}
            className={
                'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none ' +
                (active
                    ? 'border-red-900 text-slate-50 focus:border-red-700 '
                    : 'border-transparent text-slate-400 hover:border-gray-300 focus:border-red-900 ') +
                className
            }
        >
            {children}
        </Link>
    );
}
