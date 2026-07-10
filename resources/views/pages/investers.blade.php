<x-layouts.app title="Investidores" description="Soluções de investimento imobiliário com retorno estruturado em Angola. Atuamos como seu parceiro local.">

    <x-slot name="styles">
        <style>
            .glass-card {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(8px);
                border: 1px solid rgba(226, 226, 226, 0.5);
                box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.04);
            }
            .bento-grid {
                display: grid;
                grid-template-columns: repeat(12, 1fr);
                gap: 24px;
            }
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

            .image-hover {
                overflow: hidden;
                border-radius: 1rem;
            }
            .image-hover img {
                transition: transform 1s cubic-bezier(.16, 1, .3, 1), filter .6s ease;
            }
            .image-hover:hover img {
                transform: scale(1.06);
                filter: brightness(1.05);
            }
        </style>
    </x-slot>

    <!-- Hero Section -->
    <section class="hero-section relative w-full min-h-[600px] flex items-center justify-center pt-20 pb-20 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img class="hero-bg w-full h-full object-cover" src="{{ asset('assets/Real_estate_consultant_presentin…_202607021733.jpeg') }}" alt="Consultoria Imobiliária">
            <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 md:px-12 text-white">
            <div class="max-w-3xl">
                <h1 class="hero-title text-4xl md:text-6xl mb-6 font-bold leading-tight">
                    Soluções de investimento imobiliário com retorno estruturado em Angola
                </h1>
                <p class="hero-text text-lg mb-10 text-white/90 leading-relaxed">
                    Criamos soluções completas para investidores que pretendem entrar ou expandir no mercado
                    imobiliário angolano com segurança, rentabilidade e gestão profissional.
                    Atuamos como seu parceiro local.
                </p>
                <div class="hero-buttons flex flex-wrap gap-4">
                    <button class="bg-[#ff6b00] hover:bg-orange-600 text-white px-8 py-4 font-semibold rounded-lg transition-all duration-300 hover:scale-105 flex items-center gap-2">
                        Falar com um Consultor
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Market Opportunity ("Oportunidade de Mercado") -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="flex flex-col lg:flex-row gap-16">
                <!-- Conteúdo -->
                <div class="lg:w-1/2 reveal">
                    <h2 class="text-4xl font-bold mb-6 text-gray-900">Porquê Luanda Agora?</h2>
                    <div class="space-y-6 text-gray-600 leading-relaxed">
                        <p>
                            O crescimento acelerado de Luanda, impulsionado por novos polos de desenvolvimento
                            económico, gera uma demanda constante por habitação de alto padrão.
                        </p>
                        <p>
                            Existe atualmente um défice significativo de oferta qualificada, especialmente para o
                            segmento expatriado e corporate housing, onde a rentabilidade é dolarizada e as yields são
                            superiores à média regional.
                        </p>
                    </div>

                    <!-- Estatísticas -->
                    <div class="mt-10 grid grid-cols-2 gap-8">
                        <div class="reveal">
                            <div class="text-[#ff6b00] text-5xl font-bold mb-1">12%+</div>
                            <div class="text-sm text-gray-500 uppercase font-semibold tracking-wider">Yield Anual Média</div>
                        </div>
                        <div class="reveal">
                            <div class="text-[#ff6b00] text-5xl font-bold mb-1">Alto</div>
                            <div class="text-sm text-gray-500 uppercase font-semibold tracking-wider">Capital Appreciation</div>
                        </div>
                    </div>
                </div>

                <!-- Imagem -->
                <div class="lg:w-1/2 reveal">
                    <div class="relative h-[500px] w-full rounded-2xl overflow-hidden shadow-xl image-hover">
                        <img class="w-full h-full object-cover"
                            src="{{ asset('assets/An_ultra-realistic_luxury_real_estate_202607021617.jpeg') }}"
                            alt="Interior Premium">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section ("O que oferecemos") -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <!-- Cabeçalho -->
            <div class="text-center mb-16 reveal">
                <h2 class="text-4xl font-bold mb-4 text-gray-900">Serviços 360º para Investidores</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    Um ecossistema completo para gerir o seu património sem preocupações operacionais.
                </p>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach([
                    ['icon' => 'search_insights', 'title' => 'Identificação de Oportunidades', 'desc' => 'Acesso a deals off-market e ativos em zonas de alta valorização futura.'],
                    ['icon' => 'analytics', 'title' => 'Análise de Viabilidade', 'desc' => 'Estudos técnicos detalhados com projeções financeiras realistas do mercado local.'],
                    ['icon' => 'monitoring', 'title' => 'Simulação de Rendimento', 'desc' => 'Modelagem de yields líquidas considerando impostos, manutenção e gestão.'],
                    ['icon' => 'account_tree', 'title' => 'Estruturação de Modelos', 'desc' => 'Apoio jurídico e fiscal para otimizar o fluxo de capital e o retorno do investimento.'],
                    ['icon' => 'real_estate_agent', 'title' => 'Gestão Completa', 'desc' => 'Serviço chave na mão: desde a decoração até à cobrança e manutenção técnica.'],
                    ['icon' => 'corporate_fare', 'title' => 'Acesso Corporate', 'desc' => 'Colocação prioritária em empresas multinacionais e embaixadas em Luanda.']
                ] as $srv)
                <div class="glass-card p-8 rounded-2xl group hover:translate-x-2 transition duration-300">
                    <span class="material-symbols-outlined text-[#ff6b00] text-4xl mb-6 block group-hover:scale-110 transition duration-300">{{ $srv['icon'] }}</span>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-[#ff6b00] transition">{{ $srv['title'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $srv['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Investment Models -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="mb-12 text-center">
                <h2 class="font-bold text-4xl mb-4 text-gray-900">Modelos de Investimento</h2>
                <p class="text-gray-500">Escolha a estratégia que melhor se adapta ao seu perfil de risco.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Modelo 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200/50 flex flex-col justify-between">
                    <div>
                        <span class="text-[#ff6b00] text-xs font-bold uppercase tracking-wider mb-4 block">Capitalização</span>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Compra + Rentabilização</h3>
                        <p class="text-gray-500 mb-8 leading-relaxed text-sm">Aquisição direta de ativos para arrendamento de longa duração. Ideal para quem procura estabilidade e valorização do património.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <span class="material-symbols-outlined text-[#ff6b00] text-sm">check_circle</span>
                                Propriedade plena
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <span class="material-symbols-outlined text-[#ff6b00] text-sm">check_circle</span>
                                Yield de 8-12%
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <span class="material-symbols-outlined text-[#ff6b00] text-sm">check_circle</span>
                                Gestão LP incluída
                            </li>
                        </ul>
                    </div>
                    <button class="w-full border-2 border-gray-200 text-gray-800 py-3 rounded-lg font-semibold hover:bg-[#ff6b00] hover:text-white hover:border-[#ff6b00] transition duration-300">Saber mais</button>
                </div>

                <!-- Modelo 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200/50 flex flex-col justify-between">
                    <div>
                        <span class="text-[#ff6b00] text-xs font-bold uppercase tracking-wider mb-4 block">Cash-Flow</span>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Subarrendamento</h3>
                        <p class="text-gray-500 mb-8 leading-relaxed text-sm">Gestão de carteiras de terceiros com otimização de ocupação. Foco em contratos corporativos de curta e média duração.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <span class="material-symbols-outlined text-[#ff6b00] text-sm">check_circle</span>
                                Investimento reduzido
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <span class="material-symbols-outlined text-[#ff6b00] text-sm">check_circle</span>
                                Retorno rápido
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <span class="material-symbols-outlined text-[#ff6b00] text-sm">check_circle</span>
                                Escalabilidade alta
                            </li>
                        </ul>
                    </div>
                    <button class="w-full border-2 border-gray-200 text-gray-800 py-3 rounded-lg font-semibold hover:bg-[#ff6b00] hover:text-white hover:border-[#ff6b00] transition duration-300">Saber mais</button>
                </div>

                <!-- Modelo 3 -->
                <div class="bg-[#ff6b00] p-8 rounded-2xl shadow-xl flex flex-col justify-between text-white">
                    <div>
                        <span class="text-white/80 text-xs font-bold uppercase tracking-wider mb-4 block">Full Service</span>
                        <h3 class="text-2xl font-bold mb-4">Gestão Turnkey</h3>
                        <p class="text-white/95 mb-8 leading-relaxed text-sm">Desde a compra em planta até ao check-in do inquilino corporativo. Nós cuidamos de tudo, você apenas recebe o rendimento.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center gap-2 text-sm text-white/90">
                                <span class="material-symbols-outlined text-white text-sm">check_circle</span>
                                100% Passivo
                            </li>
                            <li class="flex items-center gap-2 text-sm text-white/90">
                                <span class="material-symbols-outlined text-white text-sm">check_circle</span>
                                Clientes Exclusivos
                            </li>
                            <li class="flex items-center gap-2 text-sm text-white/90">
                                <span class="material-symbols-outlined text-white text-sm">check_circle</span>
                                Relatórios mensais
                            </li>
                        </ul>
                    </div>
                    <button class="w-full bg-white text-[#ff6b00] py-3 rounded-lg font-semibold hover:bg-orange-50 transition duration-300">Solicitar Proposta</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Simulator Section ("Retorno e Performance") -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="bento-grid">
                <div class="col-span-12 lg:col-span-4 flex flex-col justify-center">
                    <h2 class="text-4xl font-bold mb-6 text-gray-900">Performance Financeira</h2>
                    <p class="text-gray-500 mb-8 leading-relaxed">Utilize o nosso simulador para projetar os retornos baseados em dados reais do mercado de Luanda (Talatona, Marginal e Kilamba).</p>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 border border-gray-200">
                            <div class="bg-[#ff6b00]/10 p-2.5 rounded-lg text-[#ff6b00]">
                                <span class="material-symbols-outlined text-2xl">trending_up</span>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 uppercase font-semibold">ROI Estimado</div>
                                <div class="text-xl font-bold text-gray-900">15% - 22% p.a.</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 border border-gray-200">
                            <div class="bg-[#ff6b00]/10 p-2.5 rounded-lg text-[#ff6b00]">
                                <span class="material-symbols-outlined text-2xl">payments</span>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 uppercase font-semibold">Payback Period</div>
                                <div class="text-xl font-bold text-gray-900">6.5 Anos</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-8 bg-gray-50 p-8 md:p-10 rounded-2xl shadow-sm border border-gray-200/50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Montante de Investimento (USD)</label>
                                <input class="w-full accent-[#ff6b00]" max="2000000" min="100000" step="50000" type="range" />
                                <div class="flex justify-between text-xs text-gray-400 mt-1">
                                    <span>$100k</span>
                                    <span class="font-bold text-[#ff6b00]">$250k</span>
                                    <span>$2M</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Ativo</label>
                                <select class="w-full p-3 rounded-lg border border-gray-200 bg-white">
                                    <option>Apartamento Premium (T2/T3)</option>
                                    <option>Escritório Corporate</option>
                                    <option>Complexo Residencial</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Zona Geográfica</label>
                                <select class="w-full p-3 rounded-lg border border-gray-200 bg-white">
                                    <option>Talatona</option>
                                    <option>Ilha de Luanda</option>
                                    <option>Mutamba / Baixa</option>
                                </select>
                            </div>
                            <button class="w-full bg-[#ff6b00] hover:bg-orange-600 text-white py-4 rounded-lg font-bold transition duration-300">Simular Agora</button>
                        </div>

                        <div class="bg-white p-6 rounded-xl border border-dashed border-gray-200 flex flex-col justify-between">
                            <div>
                                <h4 class="text-xs text-gray-400 font-semibold uppercase mb-4">Projeção de Rendimento Mensal</h4>
                                <div class="text-4xl font-bold text-gray-900">$2,450.00</div>
                                <div class="text-xs text-green-600 font-bold mt-1">+11.2% Yield Bruta</div>
                            </div>
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <h4 class="text-xs text-gray-400 font-semibold uppercase mb-4">Valorização Patrimonial (5 anos)</h4>
                                <div class="text-3xl font-bold text-gray-900">$312,000.00</div>
                                <div class="text-xs text-gray-400 mt-1">Baseado em dados históricos 2018-2023</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partnerships -->
    <section class="py-16 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <p class="text-center text-xs font-semibold text-gray-400 uppercase tracking-widest mb-10">Parcerias Estratégicas Internacionais</p>
            <div class="flex flex-wrap justify-center items-center gap-16 grayscale opacity-50 hover:grayscale-0 transition duration-300">
                @for ($i = 0; $i < 4; $i++)
                <div>
                    <img src="{{ asset('assets/Logo_Time.png') }}" alt="Parceiro" class="h-10">
                </div>
                @endfor
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