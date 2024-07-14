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
import { enUS, de } from 'date-fns/locale';

const toastOptions: PluginOptions = {};
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const locale = props.initialPage.props.locale;
        setDefaultOptions({
            locale: locale === 'de' ? de : enUS,
        });

        console.log('locale', locale);
        i18next.use(HttpBackend).init<HttpBackendOptions>({
            saveMissing: import.meta.env.VITE_ENV === 'local' && locale === 'en',
            backend: {
                loadPath: (lngs, namespaces) => {
                    return `/locales/${lngs[0]}/${namespaces[0]}.json`;
                },
                addPath: (lng, ns) => {
                    // weird bug , that if locale de that lng becomes dev. Don't know whats going on
                    if (lng === 'dev') {
                        lng = 'de';
                    }
                    return `/locales/add/${lng}/${ns}`;
                },
                withCredentials: true,
                customHeaders: () => ({
                    'X-CSRF-TOKEN':
                        document.querySelector<HTMLElement>('meta[name="csrf-token"]')?.getAttribute('content') ?? '',
                }),
            },

            lng: locale,
            supportedLngs: ['en', 'de'],
            interpolation: {
                escapeValue: false,
            },
            fallbackLng: 'en',
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
