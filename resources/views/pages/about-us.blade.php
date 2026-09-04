<x-layouts.app
    :title="$sections['seo']['title'] ?? 'Quem Somos'"
    :description="$sections['seo']['description'] ?? 'Há mais de 15 anos, a Time To Choose ajuda pessoas e empresas a escolher Angola e a escolher bem.'">

    {{-- ======================================================
         HERO
    ====================================================== --}}
    <section class="relative min-h-[600px] flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-black/45 z-10"></div>
            @php
                $aboutHeroImg = $sections['hero']['image'] ?? null;
                $aboutHeroSrc = $aboutHeroImg
                    ? (str_starts_with($aboutHeroImg, 'page-images/')
                        ? \Illuminate\Support\Facades\Storage::url($aboutHeroImg)
                        : asset('assets/' . $aboutHeroImg))
                    : asset('assets/Executives_overlooking_Luanda_sk…_202607031225.jpeg');
            @endphp
            <img src="{{ $aboutHeroSrc }}"
                 alt="Luanda Skyline"
                 class="w-full h-full object-cover scale-105">
        </div>
        <div class="relative z-20 px-6 md:px-12 max-w-7xl mx-auto w-full">
            <div class="max-w-4xl">
                <h1 class="text-4xl md:text-6xl font-bold text-white leading-tight">
                    {{ $sections['hero']['title'] ?? 'Há mais de uma década e meia, ajudamos pessoas, empresas e instituições a escolher Angola — e a escolher bem.' }}
                </h1>
            </div>
        </div>
    </section>

    {{-- ======================================================
         A NOSSA HISTÓRIA
    ====================================================== --}}
    <section class="py-24 px-6 md:px-12 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-16">
            <div class="md:col-span-5 reveal">
                <span class="font-bold tracking-widest text-sm text-[#F97316] uppercase block mb-4">
                    {{ $sections['history']['label'] ?? 'A Nossa História' }}
                </span>
                <h2 class="text-3xl md:text-4xl font-bold mb-8 text-gray-900">
                    {{ $sections['history']['title'] ?? 'Evolução, Padrão e Compromisso.' }}
                </h2>
                <div class="space-y-6 text-gray-600 text-lg leading-relaxed">
                    <p>{{ $sections['history']['text_1'] ?? 'A Time To Choose nasceu de uma convicção simples: o mercado imobiliário angolano merecia mais. Mais rigor. Mais padrão. Mais serviço.' }}</p>
                    <p>{{ $sections['history']['text_2'] ?? 'Com 30 anos de experiência internacional e mais de 15 anos dedicados exclusivamente a Angola, construímos um legado baseado na confiança e na exclusividade. Não somos apenas mediadores; somos consultores estratégicos no coração de Luanda.' }}</p>
                </div>
                <div class="mt-10 grid grid-cols-2 gap-8 border-t border-gray-200 pt-8">
                    <div>
                        <div class="text-[#F97316] text-4xl font-bold mb-1">{{ $sections['history']['stat_1_num'] ?? '30+' }}</div>
                        <div class="text-sm text-gray-500 uppercase font-bold tracking-widest">{{ $sections['history']['stat_1_label'] ?? 'Anos Globais' }}</div>
                    </div>
                    <div>
                        <div class="text-[#F97316] text-4xl font-bold mb-1">{{ $sections['history']['stat_2_num'] ?? '15+' }}</div>
                        <div class="text-sm text-gray-500 uppercase font-bold tracking-widest">{{ $sections['history']['stat_2_label'] ?? 'Anos em Angola' }}</div>
                    </div>
                </div>
            </div>
            <div class="md:col-span-7 reveal" style="transition-delay: 200ms;">
                <div class="aspect-[4/5] rounded-sm overflow-hidden">
                    @php
                        $historyImg = $sections['history']['image'] ?? null;
                        $historyImgSrc = $historyImg
                            ? (str_starts_with($historyImg, 'page-images/')
                                ? \Illuminate\Support\Facades\Storage::url($historyImg)
                                : asset('assets/' . $historyImg))
                            : asset('assets/Real_estate_consultant_welcoming…_202607030647.jpeg');
                    @endphp
                    <img src="{{ $historyImgSrc }}"
                         alt="Equipa Time To Choose"
                         class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    {{-- ======================================================
         DIFERENCIAIS
    ====================================================== --}}
    <section class="bg-gray-50 py-24">
        <div class="px-6 md:px-12 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                @foreach([
                    ['icon' => 'workspace_premium', 'title' => 'Credibilidade Certificada',
                     'desc' => 'Somos uma empresa angolana com registo ativo na ANPG e SupplHi, garantindo os mais altos níveis de compliance e transparência em todas as operações imobiliárias.'],
                    ['icon' => 'groups', 'title' => 'Capital Humano',
                     'desc' => 'Contamos com uma equipa multidisciplinar de mais de 30 profissionais qualificados, focados em soluções personalizadas para o segmento de alto rendimento e corporativo.'],
                    ['icon' => 'verified_user', 'title' => 'Segurança Jurídica',
                     'desc' => 'Operamos com seguros de responsabilidade civil e jurídica, oferecendo aos nossos clientes a tranquilidade necessária para investimentos imobiliários complexos em Angola.'],
                ] as $card)
                <div class="bg-white p-10 rounded-sm shadow-sm reveal h-full flex flex-col">
                    <span class="material-symbols-outlined text-[#F97316] text-4xl mb-6"  translate="no">{{ $card['icon'] }}</span>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $card['title'] }}</h3>
                    <p class="text-gray-600 text-base leading-relaxed flex-grow">{{ $card['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ======================================================
         EM NÚMEROS
    ====================================================== --}}
    <section class="py-24 bg-gray-900 text-white">
        <div class="px-6 md:px-12 max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-12 text-center">
                @php
                $statsData = [
                    [$sections['numbers']['stat_1_num'] ?? '+15', $sections['numbers']['stat_1_label'] ?? 'Anos no Mercado'],
                    [$sections['numbers']['stat_2_num'] ?? '+30', $sections['numbers']['stat_2_label'] ?? 'Profissionais'],
                    [$sections['numbers']['stat_3_num'] ?? '+200', $sections['numbers']['stat_3_label'] ?? 'Imóveis Ativos'],
                    [$sections['numbers']['stat_4_num'] ?? '50+', $sections['numbers']['stat_4_label'] ?? 'Clientes Globais'],
                ];
                @endphp
                @foreach($statsData as $stat)
                <div class="reveal">
                    <div class="text-[#F97316] text-5xl md:text-6xl font-bold mb-2">{{ $stat[0] }}</div>
                    <div class="text-sm text-gray-400 uppercase font-semibold tracking-widest">{{ $stat[1] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ======================================================
         PARCEIROS DE REFERÊNCIA
    ====================================================== --}}
    <section class="py-24 px-6 md:px-12 max-w-7xl mx-auto">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-16 uppercase tracking-widest reveal">
            Parceiros de Referência
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-12 gap-y-16 items-center">
            @foreach(['Chevron', 'Schlumberger', 'TechnipFMC', 'Banco Mundial', 'Unicef', 'União Europeia', 'Intercontinental', 'MSF'] as $i => $parceiro)
            <div class="flex justify-center reveal" style="transition-delay: {{ $i * 50 }}ms;">
                <img alt="{{ $parceiro }}"
                     src="{{ asset('assets/Logo_Time.png') }}"
                     class="h-10 logo-grayscale">
            </div>
            @endforeach
        </div>
    </section>

    {{-- ======================================================
         CTA FINAL
    ====================================================== --}}
    <section class="bg-[#F7F7F7] py-20">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="bg-[#F97316] rounded-sm py-20 px-8 lg:px-20 text-center">
                <h2 class="text-4xl lg:text-5xl font-bold text-white leading-tight">
                    {{ $sections['cta']['title'] ?? 'Pronto para encontrar o seu imóvel ideal?' }}
                </h2>
                <p class="text-white/90 text-xl mt-6 max-w-2xl mx-auto">
                    {{ $sections['cta']['subtitle'] ?? 'Fale com a nossa equipa e descubra as melhores oportunidades do mercado angolano.' }}
                </p>
                <div class="mt-10">
                    <a href="{{ url('/imoveis') }}"
                       class="inline-flex items-center px-8 py-4 bg-white text-[#F97316]
                              rounded-sm font-bold uppercase tracking-wider hover:scale-105 transition">
                        {{ $sections['cta']['button_text'] ?? 'Ver Imóveis' }}
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>