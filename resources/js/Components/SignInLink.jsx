export default function SignInLink({ className = '', children, ...props }) {
    return (
        <a
            {...props}
            className={`px-4 py-2 flex gap-2 rounded-lg text-zinc-950 shadow-xl inline-flex mt-5 ${className}`}
        >
            <img className="w-6 h-6" src="https://www.svgrepo.com/show/475656/google-color.svg" loading="lazy" alt="google logo"/>
            {children}
        </a>
    );
}
