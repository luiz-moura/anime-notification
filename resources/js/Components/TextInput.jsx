import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function TextInput({ type = 'text', className = '', isFocused = false, ...props }, ref) {
    const input = ref ? ref : useRef();

    useEffect(() => {
        if (isFocused) {
            input.current.focus();
        }
    }, []);

    return (
        <input
            {...props}
            type={type}
            className={
                'border-zinc-800 focus:border-red-900 focus:ring-red-900 rounded-md shadow-sm bg-zinc-900 autofill:bg-violet-900 ' +
                className
            }
            ref={input}
        />
    );
});
