import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { coverageConfigDefaults } from 'vitest/config';
export default defineConfig({
    server: {
        watch: {
            ignored: ['**/lang/**/*'],
        },
    },
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    test: {
        globals: true,
        environment: 'jsdom',
        setupFiles: ['./resources/js/setupTests.ts'],
        coverage: {
            reportsDirectory: 'vitest-coverage',
            include: ['resources/js/**/*'],
            exclude: [...coverageConfigDefaults.exclude, 'resources/js/bootstrap.ts', 'resources/js/setupTests.ts'],
        },
    },
});
