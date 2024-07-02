import './bootstrap';
import '../css/app.css';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import i18next from 'i18next';
import I18NextVue from 'i18next-vue';
import HttpBackend, { HttpBackendOptions } from 'i18next-http-backend';
import Toast, { PluginOptions } from 'vue-toastification';
// Import the CSS or use your own!
import 'vue-toastification/dist/index.css';

i18next.use(HttpBackend).init<HttpBackendOptions>({
    saveMissing: import.meta.env.VITE_ENV === 'local',
    backend: {
        withCredentials: true,
        customHeaders: () => ({
            'X-CSRF-TOKEN':
                document.querySelector<HTMLElement>('meta[name="csrf-token"]')?.getAttribute('content') ?? '',
        }),
    },

    lng: 'en',
    interpolation: {
        escapeValue: false,
    },
    fallbackLng: false,
});

const toastOptions: PluginOptions = {};
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(I18NextVue, { i18next })
            .use(Toast, toastOptions)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
