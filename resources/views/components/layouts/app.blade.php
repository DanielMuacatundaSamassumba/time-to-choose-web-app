<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $seo = $sections['seo'] ?? [];
        $metaTitle = !empty($seo['title']) ? $seo['title'] : ($title ?? 'Time To Choose | Imobiliária Luanda');
        $metaDesc  = !empty($seo['description']) ? $seo['description'] : ($description ?? 'Time To Choose - Mediação, gestão e consultoria imobiliária em Luanda, Angola.');
        $metaKeys  = !empty($seo['keywords']) ? $seo['keywords'] : 'imóveis, luanda, angola, arrendamento, venda, imobiliária';
    @endphp
    <meta name="description" content="{{ $metaDesc }}">
    <meta name="keywords" content="{{ $metaKeys }}">

    <title>{{ $metaTitle }}</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/Logo_Time.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/Logo_Time.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/Logo_Time.png') }}">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    {{-- Material Symbols --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Lexend:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        html {
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        body {
            overflow-x: hidden;
            position: relative;
            font-family: 'Inter', system-ui, sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* === Animações de entrada === */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .category-card {
            opacity: 0;
            transform: translateY(70px);
            transition: opacity .7s ease, transform .7s cubic-bezier(.22, 1, .36, 1);
        }
        .category-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .property-card {
            opacity: 0;
            transform: translateY(80px) scale(.95);
            filter: blur(8px);
            transition: opacity .8s ease, transform .8s cubic-bezier(.22, 1, .36, 1), filter .8s ease;
        }
        .property-card.show {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }

        .service-card {
            opacity: 0;
            transform: translateY(70px) scale(.95);
            filter: blur(8px);
            transition: opacity .8s ease, transform .8s cubic-bezier(.22, 1, .36, 1), filter .8s ease, box-shadow .4s ease;
        }
        .service-card.show {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0,0,0,.12);
        }

        /* === Swiper === */
        .swiper-pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 50px;
        }
        .swiper-pagination-bullet {
            width: 10px; height: 10px;
            background: #D9D9D9; opacity: 1;
            border-radius: 999px;
            transition: all .35s ease;
        }
        .swiper-pagination-bullet-active {
            width: 40px; height: 10px;
            background: #F97316;
            border-radius: 999px;
        }

        .featuredSwiper {
            width: 100%;
            overflow: visible;
            margin-left: 0;
            padding-left: 0;
        }
        .featuredSwiper .swiper-slide { height: auto; }
        .featuredSwiper .swiper-slide a { display: block; }

        /* === Logo grayscale === */
        .logo-grayscale {
            filter: grayscale(1) opacity(0.5);
            transition: all 0.3s ease;
        }
        .logo-grayscale:hover {
            filter: grayscale(0) opacity(1);
        }

        /* === Float animation === */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .floating { animation: float 6s ease-in-out infinite; }
    </style>

    {{-- Slots de estilos extras por página --}}
    {{ $styles ?? '' }}
</head>

<body class="bg-white text-gray-900">

    {{-- HEADER GLOBAL --}}
    <x-header :transparent="$headerTransparent ?? false" />

    {{-- CONTEÚDO DA PÁGINA --}}
    <main>
        {{ $slot }}
    </main>

    {{-- FOOTER GLOBAL --}}
    <x-footer />

    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    {{-- OBSERVER: Animações de entrada --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const targets = document.querySelectorAll(
                '.reveal, .category-card, .property-card, .service-card'
            );
            if (!targets.length) return;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, i) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('active', 'show');
                        }, i * 80);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            targets.forEach(el => observer.observe(el));
        });
    </script>

    {{-- Google Translate Integration --}}
    <div id="google_translate_element" style="display:none;"></div>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'pt',
                includedLanguages: 'pt,en,fr,zh-CN',
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <style>
        .goog-te-banner-frame, .goog-te-banner, .skiptranslate, #goog-gt-tt, .goog-te-balloon-frame, iframe.goog-te-banner-frame {
            display: none !important;
            visibility: hidden !important;
        }
        body {
            top: 0px !important;
        }
        .goog-text-highlight {
            background-color: transparent !important;
            box-shadow: none !important;
        }
    </style>

    {{-- Slots de scripts extras por página --}}
    {{ $scripts ?? '' }}
    @stack('scripts')

</body>
</html>
