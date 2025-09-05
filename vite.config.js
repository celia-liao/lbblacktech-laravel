import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/css/pet.css',
                'resources/js/setting.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        rollupOptions: {
            input: {
                app: 'resources/css/app.css',
                pet: 'resources/css/pet.css',
                petSetting: 'resources/js/pet-setting.js'
            },
        },
    },
});
