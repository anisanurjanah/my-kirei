import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'

import { AuthProvider } from "@/Context/AuthContext";
import { OutletProvider } from "@/Context/OutletContext";

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.jsx', { eager: true })
        return pages[`./Pages/${name}.jsx`]
    },
    setup({ el, App, props }) {
        // createRoot(el).render(<App {...props} />)
        createRoot(el).render(
            <OutletProvider>
                <AuthProvider>
                    <App {...props} />
                </AuthProvider>
            </OutletProvider>
        );
    },
    progress: {
        color: '#C60E2A',
        showSpinner: true
    }
})
