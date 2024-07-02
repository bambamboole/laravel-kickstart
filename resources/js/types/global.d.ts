import { PageProps as InertiaPageProps } from '@inertiajs/core';
import { AxiosInstance } from 'axios';
import { route as ziggyRoute } from 'ziggy-js';
import { PageProps as AppPageProps } from './';
import type { Echo as EchoType } from 'laravel-echo';
import type { Pusher as PusherType } from 'pusher-js';
declare global {
    interface Window {
        axios: AxiosInstance;
        Pusher: PusherType;
        Echo: EchoType;
    }

    let route: typeof ziggyRoute;
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
    }
}

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}

declare module '@inertiajs/vue3' {
    export function usePage<T>(): Page<T>; // the T generic will combine any type you add to it & the PageProps interface defined in @inertiajs/core
}
