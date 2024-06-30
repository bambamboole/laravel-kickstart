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
    sidebar: {
        main: Array<{
            name: string;
            route: string;
            icon: string;
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
