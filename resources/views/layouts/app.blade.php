<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>毛小孩紀念網站 - {{ $pet->pet_name }}</title>
    <link rel="shortcut icon" href="{{ asset('storage/pets/image/logo.svg') }}" type="image/x-icon" />

    <!-- META -->
    <meta name="keywords" content="信念科技有限公司 FT, 信念科技有限公司, FT, TBT, 寵物, 狗狗, 貓咪, 毛小孩, 浪浪, 寵物紀念, 寵物過世, 寵物葬儀, 紀念網站, 寵物紀念網站" />
    <meta name="description" id="metaDescription" content="為您最心愛的寵物家人架設一個永恆的紀念網站，無論何時何地都可以隨時見到您的寶貝毛小孩!" />
    <meta property="og:description" name="description" content="為您最心愛的寵物家人架設一個永恆的紀念網站，無論何時何地都可以隨時見到您的寶貝毛小孩!" />
    <meta name="author" content="信念科技有限公司技 FT" />
    <meta name="copyright" content="信念科技有限公司 FT Copyright © All rights reserved." />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="毛小孩紀念網站 - {{ $pet->pet_name }}" />
    <meta property="og:image" content="{{ asset('storage/pets/image/content.webp') }}" />
    <meta property="og:url" content="https://lbblacktech.com/{{ $slug }}" />


    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <!-- 字型載入加速 -->
    <link rel="preload" href="{{ asset('storage/pets/' . $slug . '/font/ChenYuluoyan-Thin.ttf') }}" as="font" type="font/ttf" crossorigin="anonymous" />
    <link rel="preload" href="{{ asset('storage/pets/' . $slug . '/font/GenSenRounded2TW-B-subset.otf') }}" as="font" type="font/otf" crossorigin="anonymous" />
    <link rel="preload" href="{{ asset('storage/pets/' . $slug . '/font/GenSenRounded2TW-R-subset.otf') }}" as="font" type="font/otf" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Akshar:wght@300..700&family=Noto+Sans+Display:ital,wght@0,100..900;1,100..900&family=Noto+Sans+TC:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

    <style>
        /* 手寫體 */
        @font-face {
            font-family: "hand";
            src: url("{{ asset('storage/pets/' . $slug . '/font/ChenYuluoyan-Thin.ttf') }}");
            font-weight: normal;
            font-style: normal;
        }

        /* 思源圓體 Bold */
        @font-face {
            font-family: "roundB";
            src: url("{{ asset('storage/pets/' . $slug . '/font/GenSenRounded2TW-B-subset.otf') }}");
            font-weight: bold;
            font-style: normal;
        }

        /* 思源圓體 Regular */
        @font-face {
            font-family: "roundR";
            src: url("{{ asset('storage/pets/' . $slug . '/font/GenSenRounded2TW-R-subset.otf') }}");
            font-weight: normal;
            font-style: normal;
        }
    </style>

    <!-- CSS -->
    @vite('resources/css/app.css')
    @vite('resources/css/pet.css')
    @vite('resources/css/bubble.css')
    @vite('resources/css/photoswipe.css')
    @vite('resources/css/style.css')
    @vite('resources/css/function-20250324.css')
    @vite('resources/css/svg-20250324.css')
    @vite('resources/css/continued.css')

    <!--GTM追蹤碼-->
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3M8392YXDK"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());

        gtag("config", "G-3M8392YXDK");
    </script>
    <!--GTM追蹤碼結束-->

    @stack('styles')
</head>

<body>
    @yield('content')

    <!-- JavaScript -->
    @vite('resources/js/setting.js')

    <script>
        // 傳遞路徑變數給前端
        window.PET_ASSETS = {
            slug: '{{ $slug }}',
            imagePath: '{{ asset("storage/pets/" . $slug . "/image") }}',
            audioPath: '{{ asset("storage/pets/" . $slug . "/audio") }}',
            fontPath: '{{ asset("storage/pets/" . $slug . "/font") }}',
            stylePath: '{{ asset("storage/pets/" . $slug . "/style") }}',
            jsPath: '{{ Vite::asset("resources/js/app.js") }}',
            // 構建後的 JavaScript 文件路徑
            jsFiles: {
                lifeSlides: '{{ Vite::asset("resources/js/lifeSlides.js") }}',
                main: '{{ Vite::asset("resources/js/main.js") }}',
                bubble: '{{ Vite::asset("resources/js/bubble.js") }}',
                svgColor: '{{ Vite::asset("resources/js/svgColor.js") }}',               
                loading2: '{{ Vite::asset("resources/js/loading2.js") }}',
                day: '{{ Vite::asset("resources/js/day.js") }}',
                newScroll: '{{ Vite::asset("resources/js/new-scroll.js") }}',
                videoOrImg: '{{ Vite::asset("resources/js/video-or-img.js") }}',
                footerSlogan: '{{ Vite::asset("resources/js/footer-slogan.js") }}',
                utm: '{{ Vite::asset("resources/js/utm.js") }}'
            }
        };
    </script>

    <!-- 所有 JavaScript 文件現在通過 setting.js 動態載入 -->

    <!-- 音樂 -->
    <script src="https://lbblacktech.com/assets/js/music-20250324.js?v=2025.04.15"></script>
    <!-- 功能列 -->
    <script src="https://lbblacktech.com/assets/js/function-20250324.js?v=2025.04.15"></script>
    <!-- <script src="https://lbblacktech.com/assets/js/messenger.js?v=2025.04.15"></script> -->
    <!-- 版權 -->
    <script src="https://lbblacktech.com/assets/js/copyright.js?v=2025.04.15"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Fancybox.bind("[data-fancybox]", {
                Toolbar: {
                    display: {
                        left: [],
                        middle: [],
                        right: ["zoomIn", "close"],
                    },
                },
                Thumbs: false
            });
        });
    </script>

    @stack('scripts')
</body>

</html>