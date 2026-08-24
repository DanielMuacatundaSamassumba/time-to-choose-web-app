<x-layouts.app :title="$sections['seo']['title'] ?? 'Gestão de Património'" :description="$sections['seo']['description'] ?? 'A Time To Choose assume a gestão completa dos seus imóveis em Angola. Rentabilidade, conservação, ocupação e tranquilidade total.'">

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
            @php
                $heroImg = $sections['hero']['image'] ?? null;
                $heroSrc = $heroImg
                    ? (str_starts_with($heroImg, 'page-images/') ? \Illuminate\Support\Facades\Storage::url($heroImg) : asset('assets/' . $heroImg))
                    : asset('assets/Property_manager_discussing_perf…_202607021718.jpeg');
            @endphp
            <img class="hero-bg w-full h-full object-cover"
                 src="{{ $heroSrc }}"
                 alt="Gestão de Propriedades" />
            <div class="absolute inset-0 bg-black/50"></div>
        </div>
        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 md:px-12 text-white">
            <div class="max-w-3xl">
                <h1 class="hero-title text-4xl md:text-3xl font-bold mb-6 text-white leading-tight">
                    {{ $sections['hero']['title'] ?? 'Gestão de Património' }}
                </h1>
                <p class="hero-text text-lg text-gray-200 mb-8 max-w-2xl leading-relaxed">
                    {{ $sections['hero']['subtitle'] ?? 'A Time To Choose assume a gestão completa dos seus imóveis, focando em rentabilidade, conservação, ocupação e tranquilidade total para o proprietário.' }}
                </p>
                <div class="hero-buttons flex flex-col sm:flex-row gap-4">
                    <button
                                        onclick="window.location.href='mailto:info@timetochoose.ao'"

                    class="bg-[#F97316] cursor-pointer text-white px-8 py-3.5 rounded-lg hover:scale-105 hover:bg-[#F97316]/90 transition-all duration-350 font-semibold">
                        {{ $sections['hero']['button_text'] ?? 'Solicitar Gestão' }}
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- O Que Fazemos -->
    <section class="py-24 px-6 md:px-12 max-w-7xl mx-auto bg-white">
        <div class="mb-16">
            <h2 class="reveal text-4xl mb-4 font-bold text-center text-gray-900 animate-fade-in">
                {{ $sections['services']['title'] ?? 'O Que Fazemos' }}
            </h2>
            <p class="reveal text-lg text-gray-500 text-center">
                {{ $sections['services']['subtitle'] ?? 'Gestão integral para maximizar o seu retorno e proteger o seu investimento.' }}
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach([
                ['icon' => 'avaliacao.png', 'title' => 'Avaliação comercial'],
                ['icon' => 'Estraarrendamento.png', 'title' => 'Estratégia de arrendamento'],
                ['icon' => 'promocao.png', 'title' => 'Promoção exclusiva'],
                ['icon' => 'inquilino.png', 'title' => 'Seleção de inquilinos'],
               
            ] as $srv)
            <div class="flex flex-col gap-4 bg-gray-50 p-8 rounded-2xl border border-gray-100 hover:-translate-y-2 transition duration-300 cursor-pointer">
       <img src="{{ asset('assets/' . $srv['icon']) }}" alt="" class="w-10">
            <h3 class="text-lg font-bold text-gray-900">{{ $srv['title'] }}</h3>
         <p>Gestão integral para maximizar o seu retorno e proteger o seu investimento.</p>    
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
        ['icon' => 'proprietario.png', 'title' => 'Proprietários', 'desc' => 'Gestão profissional do seu património, esteja em Angola ou no estrangeiro.'],
        ['icon' => 'Investidores-1.png', 'title' => 'Investidores', 'desc' => 'Estratégias imobiliárias para maximizar rentabilidade e valorização dos ativos.'],
        ['icon' => 'Empresas.png', 'title' => 'Empresas', 'desc' => 'Soluções completas para património imobiliário corporativo e institucional.'],
        ['icon' => 'condominio.png', 'title' => 'Condomínios', 'desc' => 'Administração integral para preservar, valorizar e otimizar os imóveis.']
    ] as $target)

        <div class="group backdrop-blur-md bg-white/10 border border-white/10 rounded-3xl p-8 transition-all duration-500 hover:-translate-y-3 hover:bg-white/15 hover:border-[#F97316]/40">

            <div class="w-16 h-16 rounded-full bg-white/10 flex items-center justify-center mb-8 transition-all duration-500 group-hover:bg-[#F97316]">
                <img
                    src="{{ asset('assets/' . $target['icon']) }}"
                    alt="{{ $target['title'] }}"
                    class="w-10 h-10 object-contain"
                >
            </div>

            <h3 class="text-2xl font-semibold text-white mb-4">
                {{ $target['title'] }}
            </h3>

            <p class="text-white/75 leading-7 text-sm">
                {{ $target['desc'] }}
            </p>

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
                <div class="w-16 h-16 rounded-full bg-[#F97316] flex items-center justify-center transition-transform duration-500 group-hover:scale-110 group-hover:rotate-6">
                     <img src="{{ asset('assets/Financeira.png') }}" alt="Gestão Financeira" class="w-10">
            </div>
                <h3 class="text-2xl font-bold text-gray-900">Gestão Financeira</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#F97316] text-sm mt-1" translate="no">check_circle</span>
                        <span class="text-gray-600 font-medium">Cobrança de rendas</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#F97316] text-sm mt-1" translate="no">check_circle</span>
                        <span class="text-gray-600 font-medium">Relatórios mensais</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#F97316] text-sm mt-1" translate="no">check_circle</span>
                        <span class="text-gray-600 font-medium">Controlo de pagamentos</span>
                    </li>
                </ul>
            </div>

            <!-- Gestão Operacional -->
            <div class="group flex flex-col gap-6 bg-gray-50 p-8 rounded-2xl border border-gray-100 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl">
                <div class="w-16 h-16 rounded-full bg-[#F97316] flex items-center justify-center transition-transform duration-500 group-hover:scale-110 group-hover:rotate-6">
                     <img src="{{ asset('assets/operacao.png') }}" alt="operacao"  class="w-10">
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Gestão Operacional</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#F97316] text-sm mt-1" translate="no">check_circle</span>
                        <span class="text-gray-600 font-medium">Manutenção preventiva e corretiva</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#F97316] text-sm mt-1" translate="no">check_circle</span>
                        <span class="text-gray-600 font-medium">Equipa de limpeza dedicada</span>
                    </li>
                </ul>
            </div>

            <!-- Gestão Comercial -->
            <div class="group flex flex-col gap-6 bg-gray-50 p-8 rounded-2xl border border-gray-100 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl">
                <div class="w-16 h-16 rounded-full bg-[#F97316] flex items-center justify-center transition-transform duration-500 group-hover:scale-110 group-hover:rotate-6">
                     <img src="{{ asset('assets/predio-comercial.png') }}" alt="predio-comercial" class="w-10">
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Gestão Comercial</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#F97316] text-sm mt-1" translate="no">check_circle</span>
                        <span class="text-gray-600 font-medium">Marketing profissional</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#F97316] text-sm mt-1" translate="no">check_circle</span>
                        <span class="text-gray-600 font-medium">Gestão de ocupação</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#F97316] text-sm mt-1" translate="no">check_circle</span>
                        <span class="text-gray-600 font-medium">Ajuste dinâmico de preços</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Diferenciação e Tipos de Imóveis -->
    @php
        $fpImg = $sections['fullpack']['image'] ?? null;
        $fpSrc = $fpImg
            ? (str_starts_with($fpImg, 'page-images/') ? \Illuminate\Support\Facades\Storage::url($fpImg) : asset('assets/' . $fpImg))
            : asset('assets/Real_estate_consultant_welcoming…_202607030647.jpeg');
    @endphp
    <section class="relative py-24 px-6 md:px-12 bg-cover bg-center overflow-hidden"
             style="background-image: url('{{ $fpSrc }}');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#0D0D0D]/90 via-[#0D0D0D]/75 to-[#0D0D0D]/40"></div>

        <!-- Conteúdo -->
        <div class="relative z-10 max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="text-4xl font-bold text-white mb-6">
                    {{ $sections['fullpack']['title'] ?? 'Modelo Full-Pack &amp; Foco Corporate' }}
                </h2>
                <p class="text-lg text-white/80 leading-relaxed mb-10">
                    {{ $sections['fullpack']['subtitle'] ?? 'Integramos serviços para oferecer uma experiência sem atritos, com forte orientação para o mercado corporativo, incluindo diplomatas e expatriados, garantindo arrendatários de alta fiabilidade.' }}
                </p>

             <div class="flex flex-col gap-5">
    @foreach([
        ['icon' => 'venda.png', 'title' => 'Venda'],
        ['icon' => 'arrendamento_longa.png', 'title' => 'Arrendamento de Longa Duração'],
        ['icon' => 'arrendamento_curta.png', 'title' => 'Arrendamento de Curta Duração']
    ] as $item)

        <div class="bg-white rounded-lg p-6 flex items-center gap-4 transition duration-300">

            <img
                src="{{ asset('assets/' . $item['icon']) }}"
                alt="{{ $item['title'] }}"
                class="w-10 h-10 object-contain"
            >

            <span class="text-gray-900 font-semibold text-lg">
                {{ $item['title'] }}
            </span>

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