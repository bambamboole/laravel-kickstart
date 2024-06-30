<script setup lang="ts">
import { computed, ref, resolveComponent } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
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
import {
    Bars3Icon,
    XMarkIcon,
    ChevronRightIcon,
} from '@heroicons/vue/24/outline';
import { usePage } from '@inertiajs/vue3';

const teams = [
    { id: 1, name: 'Heroicons', href: '#', initial: 'H', current: false },
    { id: 2, name: 'Tailwind Labs', href: '#', initial: 'T', current: false },
    { id: 3, name: 'Workcation', href: '#', initial: 'W', current: false },
];
const sidebarOpen = ref(false);
const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog
                class="relative z-50 lg:hidden"
                @close="sidebarOpen = false"
            >
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
                        <DialogPanel
                            class="relative mr-16 flex w-full max-w-xs flex-1"
                        >
                            <TransitionChild
                                as="template"
                                enter="ease-in-out duration-300"
                                enter-from="opacity-0"
                                enter-to="opacity-100"
                                leave="ease-in-out duration-300"
                                leave-from="opacity-100"
                                leave-to="opacity-0"
                            >
                                <div
                                    class="absolute left-full top-0 flex w-16 justify-center pt-5"
                                >
                                    <button
                                        type="button"
                                        class="-m-2.5 p-2.5"
                                        @click="sidebarOpen = false"
                                    >
                                        <span class="sr-only"
                                            >Close sidebar</span
                                        >
                                        <XMarkIcon
                                            class="h-6 w-6 text-white"
                                            aria-hidden="true"
                                        />
                                    </button>
                                </div>
                            </TransitionChild>
                            <!-- Sidebar component, swap this element with another sidebar if you like -->
                            <div
                                class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-2"
                            >
                                <div class="flex h-16 shrink-0 items-center">
                                    <img
                                        class="h-8 w-auto"
                                        src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                                        alt="Your Company"
                                    />
                                </div>
                                <nav class="flex flex-1 flex-col">
                                    <ul
                                        role="list"
                                        class="flex flex-1 flex-col gap-y-7"
                                    >
                                        <li>
                                            <ul
                                                role="list"
                                                class="-mx-2 space-y-1"
                                            >
                                                <li
                                                    v-for="item in $page.props
                                                        .sidebar.main"
                                                    :key="item.name"
                                                >
                                                    <Link
                                                        :href="
                                                            route(item.route)
                                                        "
                                                        :class="[
                                                            route().current(
                                                                item.route,
                                                            )
                                                                ? 'bg-gray-50 text-indigo-600'
                                                                : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600',
                                                            'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6',
                                                        ]"
                                                    >
                                                        <component
                                                            :is="
                                                                Icons[item.icon]
                                                            "
                                                            :class="[
                                                                route().current(
                                                                    item.route,
                                                                )
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
        <div
            class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col"
        >
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div
                class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white"
            >
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
                                <li
                                    v-for="item in $page.props.sidebar.main"
                                    :key="item.name"
                                >
                                    <Link
                                        :href="route(item.route)"
                                        :class="[
                                            route().current(item.route)
                                                ? 'bg-gray-50 text-indigo-600'
                                                : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600',
                                            'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6',
                                        ]"
                                    >
                                        <component
                                            :is="Icons[item.icon]"
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
                                    <li
                                        v-for="subItem in $page.props.sidebar
                                            .profile"
                                        :key="subItem.name"
                                    >
                                        <Link
                                            :href="route(subItem.route)"
                                            :class="[
                                                route().current(subItem.route)
                                                    ? 'bg-gray-50'
                                                    : 'hover:bg-gray-50',
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
                                            open
                                                ? '-rotate-90 text-gray-500'
                                                : 'text-gray-400',
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

        <div
            class="sticky top-0 z-40 flex items-center gap-x-6 bg-white px-4 py-4 shadow-sm sm:px-6 lg:hidden"
        >
            <button
                type="button"
                class="-m-2.5 p-2.5 text-gray-700 lg:hidden"
                @click="sidebarOpen = true"
            >
                <span class="sr-only">Open sidebar</span>
                <Bars3Icon class="h-6 w-6" aria-hidden="true" />
            </button>
            <div class="flex-1 font-semibold leading-6 text-gray-900">
                <slot name="header" />
            </div>
        </div>

        <main class="lg:pl-72">
            <header
                class="hidden h-16 w-full border-b bg-white lg:fixed lg:block"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>
            <div class="px-4 py-10 sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>
    </div>
    <!--    <div>-->
    <!--        <div class="min-h-screen bg-gray-100">-->
    <!--            <nav class="bg-white border-b border-gray-100">-->
    <!--                &lt;!&ndash; Primary Navigation Menu &ndash;&gt;-->
    <!--                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">-->
    <!--                    <div class="flex justify-between h-16">-->
    <!--                        <div class="flex">-->
    <!--                            &lt;!&ndash; Logo &ndash;&gt;-->
    <!--                            <div class="shrink-0 flex items-center">-->
    <!--                                <Link :href="route('dashboard')">-->
    <!--                                    <ApplicationLogo-->
    <!--                                        class="block h-9 w-auto fill-current text-gray-800"-->
    <!--                                    />-->
    <!--                                </Link>-->
    <!--                            </div>-->

    <!--                            &lt;!&ndash; Navigation Links &ndash;&gt;-->
    <!--                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">-->
    <!--                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">-->
    <!--                                    Dashboard-->
    <!--                                </NavLink>-->
    <!--                            </div>-->
    <!--                        </div>-->

    <!--                        <div class="hidden sm:flex sm:items-center sm:ms-6">-->
    <!--                            &lt;!&ndash; Settings Dropdown &ndash;&gt;-->
    <!--                                <div class="ms-3 relative">-->
    <!--                                    <Dropdown align="right" width="48">-->
    <!--                                        <template #trigger>-->
    <!--                                            <span class="inline-flex rounded-md">-->
    <!--                                                <button-->
    <!--                                                    type="button"-->
    <!--                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"-->
    <!--                                                >-->
    <!--                                                    {{ $page.props.auth.user.name }}-->

    <!--                                                    <svg-->
    <!--                                                        class="ms-2 -me-0.5 h-4 w-4"-->
    <!--                                                        xmlns="http://www.w3.org/2000/svg"-->
    <!--                                                        viewBox="0 0 20 20"-->
    <!--                                                        fill="currentColor"-->
    <!--                                                    >-->
    <!--                                                        <path-->
    <!--                                                            fill-rule="evenodd"-->
    <!--                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"-->
    <!--                                                            clip-rule="evenodd"-->
    <!--                                                        />-->
    <!--                                                    </svg>-->
    <!--                                                </button>-->
    <!--                                            </span>-->
    <!--                                        </template>-->

    <!--                                        <template #content>-->
    <!--                                            <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>-->
    <!--                                            <DropdownLink :href="route('logout')" method="post" as="button">-->
    <!--                                                Log Out-->
    <!--                                            </DropdownLink>-->
    <!--                                        </template>-->
    <!--                                    </Dropdown>-->
    <!--                                </div>-->
    <!--                        </div>-->

    <!--                        &lt;!&ndash; Hamburger &ndash;&gt;-->
    <!--                        <div class="-me-2 flex items-center sm:hidden">-->
    <!--                            <button-->
    <!--                                @click="showingNavigationDropdown = !showingNavigationDropdown"-->
    <!--                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"-->
    <!--                            >-->
    <!--                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">-->
    <!--                                    <path-->
    <!--                                        :class="{-->
    <!--                                            hidden: showingNavigationDropdown,-->
    <!--                                            'inline-flex': !showingNavigationDropdown,-->
    <!--                                        }"-->
    <!--                                        stroke-linecap="round"-->
    <!--                                        stroke-linejoin="round"-->
    <!--                                        stroke-width="2"-->
    <!--                                        d="M4 6h16M4 12h16M4 18h16"-->
    <!--                                    />-->
    <!--                                    <path-->
    <!--                                        :class="{-->
    <!--                                            hidden: !showingNavigationDropdown,-->
    <!--                                            'inline-flex': showingNavigationDropdown,-->
    <!--                                        }"-->
    <!--                                        stroke-linecap="round"-->
    <!--                                        stroke-linejoin="round"-->
    <!--                                        stroke-width="2"-->
    <!--                                        d="M6 18L18 6M6 6l12 12"-->
    <!--                                    />-->
    <!--                                </svg>-->
    <!--                            </button>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->

    <!--                &lt;!&ndash; Responsive Navigation Menu &ndash;&gt;-->
    <!--                <div-->
    <!--                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"-->
    <!--                    class="sm:hidden"-->
    <!--                >-->
    <!--                    <div class="pt-2 pb-3 space-y-1">-->
    <!--                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">-->
    <!--                            Dashboard-->
    <!--                        </ResponsiveNavLink>-->
    <!--                    </div>-->

    <!--                    &lt;!&ndash; Responsive Settings Options &ndash;&gt;-->
    <!--                    <div class="pt-4 pb-1 border-t border-gray-200">-->
    <!--                        <div class="px-4">-->
    <!--                            <div class="font-medium text-base text-gray-800">-->
    <!--                                {{ $page.props.auth.user.name }}-->
    <!--                            </div>-->
    <!--                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>-->
    <!--                        </div>-->

    <!--                        <div class="mt-3 space-y-1">-->
    <!--                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>-->
    <!--                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">-->
    <!--                                Log Out-->
    <!--                            </ResponsiveNavLink>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </nav>-->

    <!--            &lt;!&ndash; Page Heading &ndash;&gt;-->
    <!--                <header class="bg-white shadow" v-if="$slots.header">-->
    <!--                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">-->
    <!--                        <slot name="header" />-->
    <!--                    </div>-->
    <!--                </header>-->

    <!--            &lt;!&ndash; Page Content &ndash;&gt;-->
    <!--            <main>-->
    <!--                <slot />-->
    <!--            </main>-->
    <!--        </div>-->
    <!--    </div>-->
</template>
