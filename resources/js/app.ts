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
import { setDefaultOptions } from 'date-fns';
import { enUS as en, de } from 'date-fns/locale';

const toastOptions: PluginOptions = {};
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const locale = props.initialPage.props.locale;
        const dateLocales = { de, en };
        setDefaultOptions({
            locale: dateLocales[locale.current],
        });

        i18next.use(HttpBackend).init<HttpBackendOptions>({
            saveMissing: import.meta.env.VITE_ENV === 'local' && locale.current === 'en',
            backend: {
                loadPath: (lngs, namespaces) => {
                    return `/locales/${lngs[0]}/${namespaces[0]}.json`;
                },
                addPath: (lng, ns) => {
                    return `/locales/add/${lng}/${ns}`;
                },
                withCredentials: true,
                customHeaders: () => ({
                    'X-CSRF-TOKEN':
                        document.querySelector<HTMLElement>('meta[name="csrf-token"]')?.getAttribute('content') ?? '',
                }),
            },

            lng: locale.current,
            supportedLngs: locale.available,
            interpolation: {
                escapeValue: false,
            },
            fallbackLng: locale.fallback,
        });

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
