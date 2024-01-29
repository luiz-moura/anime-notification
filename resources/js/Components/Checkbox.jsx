export default function Checkbox({ className = '', ...props }) {
    return (
        <input
            {...props}
            type="checkbox"
            className={
                'rounded border-zinc-800 text-red-900 shadow-sm focus:ring-red-900 ' +
                className
            }
        />
    );
}
