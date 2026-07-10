<x-layouts.app title="Gestão de Património" description="A Time To Choose assume a gestão completa dos seus imóveis em Angola. Rentabilidade, conservação, ocupação e tranquilidade total.">

    <x-slot name="styles">
        <style>
            /* Hero Animations */
            .hero-bg {
                transform: scale(1.12);
                transition: transform 2.2s cubic-bezier(.16, 1, .3, 1);
            }
            .hero-section.hero-visible .hero-bg {
                transform: scale(1);
            }
            .hero-title, .hero-text, .hero-buttons {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity .9s ease, transform .9s cubic-bezier(.16, 1, .3, 1);
            }
            .hero-section.hero-visible .hero-title,
            .hero-section.hero-visible .hero-text,
            .hero-section.hero-visible .hero-buttons {
                opacity: 1;
                transform: translateY(0);
            }
            .hero-text { transition-delay: .25s; }
            .hero-buttons { transition-delay: .45s; }
        </style>
    </x-slot>

    <!-- Hero Section -->
    <section class="hero-section relative min-h-[600px] flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img class="hero-bg w-full h-full object-cover"
                 src="{{ asset('assets/Property_manager_discussing_perf…_202607021718.jpeg') }}"
                 alt="Gestão de Propriedades" />
            <div class="absolute inset-0 bg-black/50"></div>
        </div>
        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 md:px-12 text-white">
            <div class="max-w-3xl">
                <h1 class="hero-title text-4xl md:text-6xl font-bold mb-6 text-white leading-tight">
                    Gestão de Património
                </h1>
                <p class="hero-text text-lg text-gray-200 mb-8 max-w-2xl leading-relaxed">
                    A Time To Choose assume a gestão completa dos seus imóveis,
                    focando em rentabilidade, conservação, ocupação e
                    tranquilidade total para o proprietário.
                </p>
                <div class="hero-buttons flex flex-col sm:flex-row gap-4">
                    <button class="bg-[#FF6B00] text-white px-8 py-3.5 rounded-lg hover:scale-105 hover:bg-orange-600 transition-all duration-350 font-semibold">
                        Solicitar Gestão
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- O Que Fazemos -->
    <section class="py-24 px-6 md:px-12 max-w-7xl mx-auto bg-white">
        <div class="mb-16">
            <h2 class="reveal text-4xl mb-4 font-bold text-center text-gray-900 animate-fade-in">
                O Que Fazemos
            </h2>
            <p class="reveal text-lg text-gray-500 text-center">
                Gestão integral para maximizar o seu retorno e proteger o seu investimento.
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach([
                ['icon' => 'real_estate_agent', 'title' => 'Avaliação comercial'],
                ['icon' => 'strategy', 'title' => 'Estratégia de arrendamento'],
                ['icon' => 'campaign', 'title' => 'Promoção exclusiva'],
                ['icon' => 'how_to_reg', 'title' => 'Seleção de inquilinos'],
                ['icon' => 'contract', 'title' => 'Gestão de contratos'],
                ['icon' => 'payments', 'title' => 'Controle de rendas'],
                ['icon' => 'handyman', 'title' => 'Manutenção preventiva'],
                ['icon' => 'analytics', 'title' => 'Relatórios periódicos']
            ] as $srv)
            <div class="flex flex-col gap-4 bg-gray-50 p-8 rounded-2xl border border-gray-100 hover:-translate-y-2 transition duration-300 cursor-pointer">
                <span class="material-symbols-outlined text-[#FF6B00] text-4xl">{{ $srv['icon'] }}</span>
                <h3 class="text-lg font-bold text-gray-900">{{ $srv['title'] }}</h3>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Para Quem É Indicado -->
    <section class="relative py-28 overflow-hidden bg-cover bg-center"
             style="background-image: url('{{ asset('assets/Property_manager_discussing_perf…_202607021718.jpeg') }}');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#0D0D0D]/90 via-[#0D0D0D]/75 to-[#0D0D0D]/55"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6">
            <!-- Cards -->
            <div class="grid cursor-pointer grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">
                @foreach([
                    ['icon' => 'person', 'title' => 'Proprietários', 'desc' => 'Gestão profissional do seu património, esteja em Angola ou no estrangeiro.'],
                    ['icon' => 'trending_up', 'title' => 'Investidores', 'desc' => 'Estratégias imobiliárias para maximizar rentabilidade e valorização dos ativos.'],
                    ['icon' => 'domain', 'title' => 'Empresas', 'desc' => 'Soluções completas para património imobiliário corporativo e institucional.'],
                    ['icon' => 'apartment', 'title' => 'Condomínios', 'desc' => 'Administração integral para preservar, valorizar e otimizar os imóveis.']
                ] as $target)
                <div class="group backdrop-blur-md bg-white/10 border border-white/10 rounded-3xl p-8 transition-all duration-500 hover:-translate-y-3 hover:bg-white/15 hover:border-[#FF6B00]/40">
                    <div class="w-16 h-16 rounded-full bg-white/10 flex items-center justify-center mb-8 transition-all duration-500 group-hover:bg-[#FF6B00]">
                        <span class="material-symbols-outlined text-[#fff] text-3xl group-hover:text-white">{{ $target['icon'] }}</span>
                    </div>
                    <h3 class="text-2xl font-semibold text-white mb-4">{{ $target['title'] }}</h3>
                    <p class="text-white/75 leading-7 text-sm">{{ $target['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Detalhe dos Serviços -->
    <section class="py-24 px-6 md:px-12 max-w-7xl mx-auto bg-white">
        <h2 class="reveal text-4xl mb-16 text-center font-bold text-gray-900">
            Detalhe dos Serviços
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Gestão Financeira -->
            <div class="group flex flex-col gap-6 bg-gray-50 p-8 rounded-2xl border border-gray-100 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl">
                <div class="w-16 h-16 rounded-full bg-[#FF6B00] flex items-center justify-center transition-transform duration-500 group-hover:scale-110 group-hover:rotate-6">
                    <span class="material-symbols-outlined text-white text-3xl">account_balance</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Gestão Financeira</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#FF6B00] text-sm mt-1">check_circle</span>
                        <span class="text-gray-600 font-medium">Cobrança de rendas</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#FF6B00] text-sm mt-1">check_circle</span>
                        <span class="text-gray-600 font-medium">Relatórios mensais</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#FF6B00] text-sm mt-1">check_circle</span>
                        <span class="text-gray-600 font-medium">Controlo de pagamentos</span>
                    </li>
                </ul>
            </div>

            <!-- Gestão Operacional -->
            <div class="group flex flex-col gap-6 bg-gray-50 p-8 rounded-2xl border border-gray-100 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl">
                <div class="w-16 h-16 rounded-full bg-[#FF6B00] flex items-center justify-center transition-transform duration-500 group-hover:scale-110 group-hover:rotate-6">
                    <span class="material-symbols-outlined text-white text-3xl">engineering</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Gestão Operacional</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#FF6B00] text-sm mt-1">check_circle</span>
                        <span class="text-gray-600 font-medium">Manutenção preventiva e corretiva</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#FF6B00] text-sm mt-1">check_circle</span>
                        <span class="text-gray-600 font-medium">Equipa de limpeza dedicada</span>
                    </li>
                </ul>
            </div>

            <!-- Gestão Comercial -->
            <div class="group flex flex-col gap-6 bg-gray-50 p-8 rounded-2xl border border-gray-100 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl">
                <div class="w-16 h-16 rounded-full bg-[#FF6B00] flex items-center justify-center transition-transform duration-500 group-hover:scale-110 group-hover:rotate-6">
                    <span class="material-symbols-outlined text-white text-3xl">storefront</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Gestão Comercial</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#FF6B00] text-sm mt-1">check_circle</span>
                        <span class="text-gray-600 font-medium">Marketing profissional</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#FF6B00] text-sm mt-1">check_circle</span>
                        <span class="text-gray-600 font-medium">Gestão de ocupação</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#FF6B00] text-sm mt-1">check_circle</span>
                        <span class="text-gray-600 font-medium">Ajuste dinâmico de preços</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Diferenciação e Tipos de Imóveis -->
    <section class="relative py-24 px-6 md:px-12 bg-cover bg-center overflow-hidden"
             style="background-image: url('{{ asset('assets/Real_estate_consultant_welcoming…_202607030647.jpeg') }}');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#0D0D0D]/90 via-[#0D0D0D]/75 to-[#0D0D0D]/40"></div>

        <!-- Conteúdo -->
        <div class="relative z-10 max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="text-4xl font-bold text-white mb-6">Modelo Full-Pack &amp; Foco Corporate</h2>
                <p class="text-lg text-white/80 leading-relaxed mb-10">
                    Integramos serviços para oferecer uma experiência sem atritos,
                    com forte orientação para o mercado corporativo, incluindo
                    diplomatas e expatriados, garantindo arrendatários de alta
                    fiabilidade.
                </p>

                <div class="flex flex-col gap-5">
                    @foreach([
                        ['icon' => 'schedule', 'title' => 'Curta Duração'],
                        ['icon' => 'calendar_month', 'title' => 'Longa Duração'],
                        ['icon' => 'location_city', 'title' => 'Novos Empreendimentos']
                    ] as $item)
                    <div class="bg-white rounded-lg p-6 flex items-center gap-4 transition duration-300">
                        <span class="material-symbols-outlined text-[#FF6B00] text-3xl">{{ $item['icon'] }}</span>
                        <span class="text-gray-900 font-bold text-lg">{{ $item['title'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const hero = document.querySelector(".hero-section");
            if (hero) {
                setTimeout(() => {
                    hero.classList.add("hero-visible");
                }, 300);
            }
        });
    </script>
    @endpush

</x-layouts.app>