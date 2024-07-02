import '@testing-library/jest-dom';
import { it, expect } from 'vitest';
import { screen, render } from '@testing-library/vue';
import Welcome from '@/Pages/Welcome.vue';

const getSharedPageAuth = (isAuth: boolean = false) => {
    return {
        props: {
            auth: { user: isAuth ? {} : null },
        },
    };
};

it('Shows login/register links if the user is not authenticated', async () => {
    render(Welcome, {
        props: {
            canLogin: true,
            canRegister: true,
            laravelVersion: '11',
            phpVersion: '8.3',
        },
        global: {
            mocks: { $page: getSharedPageAuth() },
        },
    });

    expect(screen.getByRole('link', { name: /log/i })).toBeInTheDocument();
    expect(screen.getByRole('link', { name: /register/i })).toBeInTheDocument();
});

it('Shows a dashboard link if the user is authenticated', async () => {
    render(Welcome, {
        props: {
            canLogin: true,
            laravelVersion: '11',
            phpVersion: '8.3',
        },
        global: {
            mocks: { $page: getSharedPageAuth(true) },
        },
    });

    expect(screen.getByRole('link', { name: /dashboard/i })).toBeInTheDocument();
});
