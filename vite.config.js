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
                'resources/css/bubble.css',
                'resources/css/font.css',
                'resources/css/photoswipe.css',
                'resources/css/style.css',
                'resources/css/function-20250324.css',
                'resources/css/svg-20250324.css',
                'resources/css/continued.css',
                'resources/js/setting.js',
                'resources/js/bubble.js',
                'resources/js/lifeSlides.js',
                'resources/js/main.js',
                'resources/js/svgColor.js',
                'resources/js/photoswipe.umd.min.js',
                'resources/js/photoswipe-lightbox.umd.min.js',
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
            input: {
                app: 'resources/css/app.css',
                pet: 'resources/css/pet.css',
                bubble: 'resources/css/bubble.css',
                photoswipe: 'resources/css/photoswipe.css',
                style: 'resources/css/style.css',
                function: 'resources/css/function-20250324.css',
                svg: 'resources/css/svg-20250324.css',
                continued: 'resources/css/continued.css',
                setting: 'resources/js/setting.js',
                bubbleJs: 'resources/js/bubble.js',
                lifeSlides: 'resources/js/lifeSlides.js',
                main: 'resources/js/main.js',
                svgColor: 'resources/js/svgColor.js',
                photoswipeJs: 'resources/js/photoswipe.umd.min.js',
                photoswipeLightbox: 'resources/js/photoswipe-lightbox.umd.min.js',
                loading2: 'resources/js/loading2.js',
                day: 'resources/js/day.js',
                newScroll: 'resources/js/new-scroll.js',
                videoOrImg: 'resources/js/video-or-img.js',
                footerSlogan: 'resources/js/footer-slogan.js',
                utm: 'resources/js/utm.js'
            },
        },
    },
});
