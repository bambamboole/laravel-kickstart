import { config } from '@vue/test-utils';
import { route } from 'ziggy-js';
// @ts-ignore yes Ziggy is there.
import { Ziggy } from '@/ziggy';
import { createHeadManager } from '@inertiajs/core';

//mocking Ziggy
config.global.mocks.route = (name: string) => route(name, undefined, undefined, Ziggy);

// fixes TypeError: Cannot read properties of undefined (reading 'createProvider')
const mockedHeadManager = createHeadManager(
    false,
    () => '',
    () => '',
);
config.global.mocks.$headManager = mockedHeadManager;
