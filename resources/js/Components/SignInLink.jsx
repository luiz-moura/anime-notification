export default function SignInLink({ className = '', children, ...props }) {
    return (
        <a
            {...props}
            className={`flex gap-2 inline-flex ${className}`}
        >
            <img className="w-6 h-6" src="https://www.svgrepo.com/show/475656/google-color.svg" loading="lazy" alt="google logo"/>
            {children}
        </a>
    );
}
