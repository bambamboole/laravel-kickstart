export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    locale: string;
    sidebar: {
        main: Array<{
            name: string;
            icon: string;
            route: string;
            params?: Record<keyof any, unknown>;
            permission?: string | null;
        }>;
        profile: Array<{
            name: string;
            route: string;
        }>;
    };
    mainNavigation: Array<{
        name: string;
        route: string;
        icon: string;
    }>;
    profileNavigation: Array<{
        name: string;
        route: string;
    }>;
};
