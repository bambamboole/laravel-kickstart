<script setup lang="ts">
import { onMounted, ref } from 'vue';

import { Link } from '@inertiajs/vue3';
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
    Disclosure,
    DisclosurePanel,
    DisclosureButton,
} from '@headlessui/vue';
import * as Icons from '@heroicons/vue/24/outline';
import { Bars3Icon, XMarkIcon, ChevronRightIcon } from '@heroicons/vue/24/outline';
import Toast from '@/Components/Toast.vue';
const iconComponents = Object.fromEntries(Object.entries(Icons).map(([key, value]) => [key, value]));
const sidebarOpen = ref(false);
</script>

<template>
    <div>
        <Toast />
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog class="relative z-50 lg:hidden" @close="sidebarOpen = false">
                <TransitionChild
                    as="template"
                    enter="transition-opacity ease-linear duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="transition-opacity ease-linear duration-300"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-gray-900/80" />
                </TransitionChild>

                <div class="fixed inset-0 flex">
                    <TransitionChild
                        as="template"
                        enter="transition ease-in-out duration-300 transform"
                        enter-from="-translate-x-full"
                        enter-to="translate-x-0"
                        leave="transition ease-in-out duration-300 transform"
                        leave-from="translate-x-0"
                        leave-to="-translate-x-full"
                    >
                        <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                            <TransitionChild
                                as="template"
                                enter="ease-in-out duration-300"
                                enter-from="opacity-0"
                                enter-to="opacity-100"
                                leave="ease-in-out duration-300"
                                leave-from="opacity-100"
                                leave-to="opacity-0"
                            >
                                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                                    <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                                        <span class="sr-only">Close sidebar</span>
                                        <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                    </button>
                                </div>
                            </TransitionChild>
                            <!-- Sidebar component, swap this element with another sidebar if you like -->
                            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-2">
                                <div class="flex h-16 shrink-0 items-center">
                                    <img
                                        class="h-8 w-auto"
                                        src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                                        alt="Your Company"
                                    />
                                </div>
                                <nav class="flex flex-1 flex-col">
                                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                        <li>
                                            <ul role="list" class="-mx-2 space-y-1">
                                                <li v-for="item in $page.props.sidebar.main" :key="item.name">
                                                    <Link
                                                        :href="route(item.route, item.params)"
                                                        :class="[
                                                            route().current(item.route)
                                                                ? 'bg-gray-50 text-indigo-600'
                                                                : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600',
                                                            'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6',
                                                        ]"
                                                    >
                                                        <component
                                                            :is="iconComponents[item.icon]"
                                                            :class="[
                                                                route().current(item.route)
                                                                    ? 'foobar text-indigo-600'
                                                                    : 'text-gray-400 group-hover:text-indigo-600',
                                                                'h-6 w-6 shrink-0',
                                                            ]"
                                                            aria-hidden="true"
                                                        />
                                                        {{ item.name }}
                                                    </Link>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white">
                <div class="flex h-16 shrink-0 items-center border-b">
                    <img
                        class="h-8 w-auto"
                        src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                        alt="Your Company"
                    />
                </div>
                <nav class="flex flex-1 flex-col px-6">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li v-for="item in $page.props.sidebar.main" :key="item.name">
                                    <Link
                                        :href="route(item.route, item.params)"
                                        :class="[
                                            route().current(item.route)
                                                ? 'bg-gray-50 text-indigo-600'
                                                : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600',
                                            'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6',
                                        ]"
                                    >
                                        <component
                                            :is="iconComponents[item.icon]"
                                            :class="[
                                                route().current(item.route)
                                                    ? 'text-indigo-600'
                                                    : 'text-gray-400 group-hover:text-indigo-600',
                                                'h-6 w-6 shrink-0',
                                            ]"
                                            aria-hidden="true"
                                        />
                                        {{ item.name }}
                                    </Link>
                                </li>
                            </ul>
                        </li>
                        <li class="-mx-6 mt-auto">
                            <Disclosure as="div" v-slot="{ open }">
                                <DisclosurePanel as="ul" class="mt-1 px-2">
                                    <li v-for="subItem in $page.props.sidebar.profile" :key="subItem.name">
                                        <Link
                                            :href="route(subItem.route)"
                                            :class="[
                                                route().current(subItem.route) ? 'bg-gray-50' : 'hover:bg-gray-50',
                                                'block rounded-md py-2 pl-9 pr-2 text-sm leading-6 text-gray-700',
                                            ]"
                                            >{{ subItem.name }}</Link
                                        >
                                    </li>
                                </DisclosurePanel>
                                <DisclosureButton
                                    class="flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50"
                                >
                                    {{ $page.props.auth.user.name }}
                                    <ChevronRightIcon
                                        :class="[
                                            open ? '-rotate-90 text-gray-500' : 'text-gray-400',
                                            'ml-auto h-5 w-5 shrink-0',
                                        ]"
                                        aria-hidden="true"
                                    />
                                </DisclosureButton>
                            </Disclosure>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-white px-4 py-4 shadow-sm sm:px-6 lg:hidden">
            <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = true">
                <span class="sr-only">Open sidebar</span>
                <Bars3Icon class="h-6 w-6" aria-hidden="true" />
            </button>
            <div class="flex-1 font-semibold leading-6 text-gray-900">
                <slot name="header" />
            </div>
        </div>

        <main class="lg:pl-72">
            <header class="hidden h-16 w-full border-b bg-white lg:fixed lg:block" v-if="$slots.header">
                <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>
            <div class="px-4 py-10 sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>
    </div>
</template>
