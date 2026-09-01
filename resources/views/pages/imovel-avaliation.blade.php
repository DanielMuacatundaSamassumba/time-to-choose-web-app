<x-layouts.app
    :title="$sections['seo']['title'] ?? 'Avaliação Imobiliária Profissional'"
    :description="$sections['seo']['description'] ?? 'Determine o valor real de mercado do seu património em Angola. Análise técnica e inteligência de mercado.'">

    {{-- Styles extras para a página --}}
    <x-slot name="styles">
        <style>
            .shadow-ambient {
                box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.04);
            }

            .shadow-hover {
                box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.08);
            }

            .card-hover {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .card-hover:hover {
                transform: translateY(-6px);
                box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.1);
            }

            .check-item {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            /* Hero Animations */
            .hero-bg {
                transform: scale(1.12);
                transition: transform 2.2s cubic-bezier(.16, 1, .3, 1);
            }

            .hero-section.hero-visible .hero-bg {
                transform: scale(1);
            }

            .hero-title,
            .hero-text,
            .hero-buttons {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity .9s ease, transform .9s cubic-bezier(.16, 1, .3, 1);
            }

            .hero-section.hero-visible .hero-text,
            .hero-section.hero-visible .hero-buttons {
                opacity: 1;
                transform: translateY(0);
            }

            .hero-text {
                transition-delay: .25s;
            }

            .hero-buttons {
                transition-delay: .45s;
            }
        </style>
    </x-slot>

    {{-- Hero Section --}}
    <section class="hero-section relative min-h-[600px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            @php
                $heroImg = $sections['hero']['image'] ?? null;
                $heroSrc = $heroImg
                    ? (str_starts_with($heroImg, 'page-images/') ? \Illuminate\Support\Facades\Storage::url($heroImg) : asset('assets/' . $heroImg))
                    : asset('assets/Real_estate_valuation_report_pre…_202607021706.jpeg');
            @endphp
            <img class="hero-bg w-full h-full object-cover" src="{{ $heroSrc }}" alt="Relatório de Avaliação" />
            <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 md:px-12 flex flex-col md:flex-row items-center gap-16">
            <div class="w-full md:w-3/5 flex flex-col gap-8">
                <h1 class="hero-title text-4xl md:text-3xl text-white font-bold leading-tight">
                    {{ $sections['hero']['title'] ?? 'Avaliação Imobiliária' }}
                </h1>
                <p class="hero-text text-lg text-gray-200 max-w-xl leading-relaxed">
                    {{ $sections['hero']['subtitle'] ?? 'Determine o valor real de mercado do seu património em Angola. Combinamos análise técnica rigorosa com inteligência estratégica de mercado.' }}
                </p>
                <div class="hero-buttons flex flex-col sm:flex-row gap-5 mt-4">
                    <button onclick="window.location.href='mailto:info@timetochoose.ao'"
                        class="bg-[#F97316] text-white font-bold py-4 px-10 rounded-sm transition-all hover:scale-[1.02] hover:shadow-xl active:scale-95">
                        {{ $sections['hero']['button_text'] ?? 'Solicitar Avaliação' }}
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- O que oferecemos --}}
    <section class="py-32 bg-white px-6 md:px-12">
        <div class="max-w-7xl mx-auto">
            <div class="mb-20  max-w-3xl  reveal">
                <h2 class="font-bold text-4xl mb-6">{{ $sections['methodology']['title'] ?? 'Nossa Metodologia' }}</h2>
                <p class="text-lg text-gray-500 leading-relaxed">
                    {{ $sections['methodology']['subtitle'] ?? 'Utilizamos um processo estruturado e analítico para garantir que o valor apurado reflete a realidade económica e as particularidades de cada imóvel.' }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach([
                        ['icon' => 'analise.png', 'title' => 'Análise Geográfica', 'desc' => 'Avaliação aprofundada da localização, acessos, infraestrutura envolvente e planos de desenvolvimento municipal.'],
                        ['icon' => 'Inspeção.png', 'title' => 'Inspeção Técnica', 'desc' => 'Análise rigorosa do estado de conservação, qualidade de acabamentos, áreas úteis e conformidade estrutural.'],
                        ['icon' => 'Estudo.png', 'title' => 'Estudo de Mercado', 'desc' => 'Comparação com transações recentes e ofertas ativas em zonas homólogas, garantindo realismo comercial.'],
                        ['icon' => 'Cálculo.png', 'title' => 'Cálculo de Yields', 'desc' => 'Projeção de rendimentos para investidores, baseada em taxas de ocupação e preços de arrendamento praticados.'],
                        ['icon' => 'certificacao.png', 'title' => 'Sugestão de Valorização', 'desc' => 'Identificação de intervenções ou mudanças de uso que podem incrementar significativamente o valor final.'],
                        ['icon' => 'Sugestão.png', 'title' => 'Certificação Final', 'desc' => 'Entrega de dossiê completo, com fundamentação técnica e parecer profissional assinado pela nossa gestão.']
                    ] as $item)

                    <div class="group bg-gray-50 p-10 rounded-sm border border-gray-200/50 card-hover reveal">

                        <div
                            class="w-14 h-14 p-2 rounded-sm bg-[#F97316] shadow-sm flex items-center justify-center mb-8 group-hover:bg-[#F97316] text-white transition-colors">

                            <img src="{{ asset('assets/' . $item['icon']) }}" alt="">

                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-4">
                            {{ $item['title'] }}
                        </h3>

                        <p class="text-gray-500 leading-relaxed">
                            {{ $item['desc'] }}
                        </p>

                    </div>

                @endforeach
            </div>
        </div>
    </section>

    {{-- Para que serve / Objectivos --}}
    <section class="py-32 bg-gray-50 px-6 md:px-12 relative overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-20">
                <div class="lg:col-span-6 flex flex-col gap-12">
                    <div>
                        <h2 class="text-4xl font-bold text-gray-900 mb-6">
                            {{ $sections['objectives']['title'] ?? 'Objectivos da Avaliação' }}
                        </h2>
                        <p class="text-gray-500 max-w-md">
                            {{ $sections['objectives']['subtitle'] ?? 'Entenda como o nosso relatório se torna uma ferramenta de poder na sua mão.' }}
                        </p>
                    </div>
                    <div class="space-y-6">
                        @foreach([
                                ['title' => 'Venda Estratégica', 'desc' => 'Não perca dinheiro com subavaliações nem tempo com preços fora da realidade. Saia ao mercado com confiança.'],
                                ['title' => 'Optimizar Rendimento', 'desc' => 'Defina rendas competitivas que garantam ocupação rápida e rentabilidade máxima para o seu activo imobiliário.'],
                                ['title' => 'Decisão de Investimento', 'desc' => 'Analise a viabilidade de compra de novos activos com base em fundamentos sólidos e projecções de valorização.']
                            ] as $obj)
                            <div
                                class="flex gap-6 p-8 rounded-sm bg-white border border-gray-200/50 shadow-sm transition-all hover:border-[#F97316]/30 cursor-pointer">
                                <div
                                    class="shrink-0 w-14 h-14 rounded-sm bg-[#F97316] text-white flex items-center justify-center">
                                    <span class="material-symbols-outlined"  translate="no">sell</span>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $obj['title'] }}</h4>
                                    <p class="text-gray-500 leading-relaxed">{{ $obj['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="lg:col-span-6 flex flex-col gap-10">
                    <h2 class="text-4xl font-bold text-gray-900 reveal">
                        {{ $sections['modalities']['title'] ?? 'Modalidades de Serviço' }}
                    </h2>
                 <div class="grid grid-cols-1 gap-6">
    @foreach([
        ['title' => 'Comercial', 'desc' => 'Focada em liquidez e transacção imediata de mercado.', 'icon' => 'loja-de-compras.png'],
        ['title' => 'Técnica Estrutural', 'desc' => 'Auditoria completa para reabilitação ou seguros.', 'icon' => 'estrutural.png'],
        ['title' => 'Para Investidores', 'desc' => 'Análise de Yield, TIR e viabilidade económica.', 'icon' => 'investidor.png']
    ] as $mod)

        <div class="group reveal flex items-center justify-between p-8 bg-white rounded-sm border-l-8 border-[#F97316] shadow-sm hover:translate-x-2 transition duration-300">

            <div class="max-w-[70%]">
                <h5 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-[#F97316] transition">
                    {{ $mod['title'] }}
                </h5>

                <p class="text-sm text-gray-500">
                    {{ $mod['desc'] }}
                </p>
            </div>

            <img src="{{ asset('assets/' . $mod['icon']) }}" alt="" class="w-12">

        </div>

    @endforeach
</div>

                    {{-- Checklist --}}
                    <div class="bg-[#ffff] rounded-sm p-8 mt-4 reveal">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="material-symbols-outlined text-[#F97316]" translate="no">checklist</span>
                            <h4 class="text-2xl font-bold text-gray-900">Checklist de Documentos</h4>
                        </div>
                        <ul class="space-y-4">
                            @foreach([
                                    'Caderneta Predial Actualizada',
                                    'Certidão do Registo Predial',
                                    'Matriz do Imóvel',
                                    'Planta de Arquitectura (se disponível)',
                                    'Documento de Identificação do Proprietário'
                                ] as $doc)
                                <li class="check-item">
                                    <span class="material-symbols-outlined text-[#F97316] text-sm" translate="no"
                                        style="font-variation-settings:'FILL' 1;">check_circle</span>
                                    <span class="text-gray-700 font-medium">{{ $doc }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
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