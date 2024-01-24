import * as Sentry from "@sentry/react"

export const init = () => {
    Sentry.init({
        dsn: import.meta.env.VITE_SENTRY_DSN_PUBLIC,
    });
}
