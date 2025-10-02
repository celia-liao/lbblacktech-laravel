import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/css/pet.css',
                'resources/css/bubble.css',
                'resources/css/photoswipe.css',
                'resources/css/style.css',
                'resources/css/function-20250324.css',
                'resources/css/svg-20250324.css',
                'resources/css/continued.css',
                'resources/js/app.js',
                'resources/js/svgColor.js',
                'resources/js/setting.js',
                'resources/js/bubble.js',
                'resources/js/lifeSlides.js',
                'resources/js/main.js',
                'resources/js/loading2.js',
                'resources/js/day.js',
                'resources/js/new-scroll.js',
                'resources/js/video-or-img.js',
                'resources/js/footer-slogan.js',
                'resources/js/utm.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        rollupOptions: {
        
        },
    },
});
