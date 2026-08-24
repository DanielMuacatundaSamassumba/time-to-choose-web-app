<x-layouts.app title="Página Inicial" :headerTransparent="true">

    {{-- ======================================================
    HERO SECTION
    ====================================================== --}}
    <section class="relative h-[700px] lg:h-[650px] overflow-visible">

        {{-- Video --}}
        <video autoplay muted loop playsinline preload="auto" class="absolute inset-0 w-full h-full object-cover z-0">
            <source src="https://xamariz.ao/wp-content/uploads/revslider/slider-11/videoplayback.mp4" type="video/mp4">
        </video>

        {{-- Overlay --}}
        <div class="absolute inset-0 bg-black/50 z-10"></div>

        {{-- HERO CONTENT --}}
        <div class="relative z-20 h-full flex items-center justify-center">
            <div class="text-center px-6 max-w-5xl">
                <h1 class="text-white font-bold leading-tight text-4xl md:text-6xl lg:text-7xl">
                    {!! $sections['hero']['title'] ?? 'Viver bem em Luanda <br/> é uma escolha.' !!}
                </h1>
                <p class="text-white/90 mt-6 text-lg md:text-xl">
                    {{ $sections['hero']['subtitle'] ?? 'Mais de 200 imóveis premium em Luanda com o acompanhamento que merece' }}
                </p>
            </div>
        </div>

        {{-- SEARCH BAR --}}
        <div class="p-3">
            <div x-data="{ open: false }" class="relative -mt-40
                        lg:absolute lg:left-1/2 lg:-translate-x-1/2 lg:bottom-[-40px]
                        w-full max-w-7xl
                        bg-[#F97316] rounded-2xl shadow-2xl p-6 z-30">

                <form action="{{ route('properties.index') }}" method="GET">
                    {{-- ROW 1 --}}
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                        <input type="text" name="search" placeholder="Pesquisar cidade, título ou zona..."
                            class="h-14 rounded-xl px-5 outline-none text-sm text-gray-800 placeholder-gray-400">

                        <select name="category"
                            class="h-14 rounded-xl px-5 outline-none text-sm text-gray-500 cursor-pointer">
                            <option value="">Tipo de Negócio</option>
                            <option value="venda">Venda</option>
                            <option value="arrendamento-longa-duracao">Arrendamento de Longa Duração</option>
                            <option value="arrendamento-curta-duracao">Arrendamento de Curta Duração</option>
                            <option value="transpasse">Transpasse</option>
                        </select>

                        <select name="property_type" id="hp_property_type"
                            class="h-14 rounded-xl px-5 outline-none text-sm text-gray-500 cursor-pointer">
                            <option value="">Tipo de Imóvel</option>
                            <option value="apartamento">Apartamento</option>
                            <option value="vivenda">Vivenda</option>
                            <option value="terrenos ">Terrenos  </option>
                            <option value="Espacos-comercias">Espaços Comerciais</option>
                        </select>

                        <div class="flex items-center gap-3">
                            <button type="button" @click="open=!open"
                                class="flex items-center gap-2 text-white border border-white/70 rounded-xl px-4 py-3 hover:bg-white/10 transition shrink-0">
                                <span class="material-symbols-outlined transition duration-300"  translate="no"
                                    :class="open ? 'rotate-180' : ''">tune</span>
                            </button>
                            <button type="submit" class="flex-1 h-14 rounded-xl bg-white text-[#F97316]/90 uppercase tracking-wider text-sm
                                           font-bold transition duration-300">
                                Pesquisar
                            </button>
                        </div>
                    </div>

                    {{-- ROW 2: Filtros expandidos --}}
                    <div x-show="open" x-cloak x-collapse class="overflow-hidden">
                        <div class="border-t border-white/30 my-5"></div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                            <select name="country"
                                class="h-14 rounded-xl px-5 text-sm text-gray-500 outline-none cursor-pointer">
                                <option value="">Todos os Países</option>
                                <option value="Angola">Angola</option>
                                <option value="Portugal">Portugal</option>
                                <option value="África do Sul">África do Sul</option>
                            </select>

                            <select name="city"
                                class="h-14 rounded-xl px-5 text-sm text-gray-500 outline-none cursor-pointer">
                                <option value="">Todas as Cidades</option>
                                <option value="Luanda">Luanda</option>
                                <option value="Benguela">Benguela</option>
                                <option value="Lisboa">Lisboa</option>
                                <option value="Porto">Porto</option>
                                <option value="Pretória">Pretória</option>
                                <option value="Joanesburgo">Joanesburgo</option>
                            </select>

                            <div x-data="{
                                pt: '',
                                get prefix() {
                                    if (this.pt === 'vivenda') return 'V';
                                    if (this.pt === 'Espacos-comercias') return 'm²';
                                    return 'T';
                                }
                            }"
                                x-init="() => { document.getElementById('hp_property_type').addEventListener('change', e => pt = e.target.value) }">
                                <select name="typology"
                                    class="h-14 rounded-xl px-5 text-sm text-gray-500 outline-none w-full cursor-pointer">
                                    <option value="">Tipologia</option>
                                    <template x-for="n in [0,1,2,3,4,5]" :key="n">
                                        <option :value="n" x-text="prefix + n"></option>
                                    </template>
                                    <option :value="'6+'" x-text="prefix + '6+'"></option>
                                </select>
                            </div>

                            <div class="flex justify-end">
                                <button type="reset" class="h-14 px-6 rounded-xl border border-white text-white text-sm font-semibold
                                               hover:bg-white hover:text-[#F97316] transition w-full">
                                    Limpar Filtros
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>

    {{-- Espaço para compensar a barra flutuante --}}
    <div class="h-40"></div>


    {{-- ======================================================
    TIPOS DE PROPRIEDADES
    ====================================================== --}}
    <section class="py-24 bg-white">
        <div class="w-full max-w-7xl mx-auto px-4 lg:px-6 flex flex-col items-center justify-center">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10 w-full">
                <div class="text-start lg:text-left">
                    <span class="text-[#F97316] text-sm md:text-base lg:text-lg font-semibold uppercase">
                        {{ $sections['categories']['tag'] ?? 'TIPOS DE PROPRIEDADES' }}
                    </span>
                    <h2 class="mt-3 text-3xl md:text-4xl lg:text-4xl font-bold">
                        {{ $sections['categories']['title'] ?? 'Encontre o seu lugar em Luanda' }}
                    </h2>
                </div>
            </div>

            @php
                $categories = [
                    [
                        'label' => 'Venda',
                        'filter' => 'category=venda',
                        'query' => fn() => \App\Models\Property::where('is_active', true)->where('type', 'venda')->count(),
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    ],
                    [
                        'label' => 'Arrendamento Longa Duração',
                        'filter' => 'category=arrendamento-longa-duracao',
                        'query' => fn() => \App\Models\Property::where('is_active', true)->where('category', 'arrendamento-longa-duracao')->count(),
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                    ],
                    [
                        'label' => 'Arrendamento Curta Duração',
                        'filter' => 'category=arrendamento-curta-duracao',
                        'query' => fn() => \App\Models\Property::where('is_active', true)->where('category', 'arrendamento-curta-duracao')->count(),
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    ],
                    [
                        'label' => 'Transpasse',
                        'filter' => 'category=transpasse',
                        'query' => fn() => \App\Models\Property::where('is_active', true)->where('category', 'transpasse')->count(),
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
                    ],
                ];
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-center justify-center w-full">
                @foreach($categories as $cat)
                    @php $count = ($cat['query'])(); @endphp
                    <a href="{{ url('/imoveis') . '?' . $cat['filter'] }}" class="category-card bg-white rounded-[24px] border border-[#DADADA]
                              h-[190px] p-3 flex flex-col items-center justify-center
                              shadow-[0_8px_0_#F97316] hover:-translate-y-2 transition-all duration-300">
                        <div class="w-20 h-20 rounded-full bg-[#FAD38D] flex items-center justify-center mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-[#F97316]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                {!! $cat['icon'] !!}
                            </svg>
                        </div>
                        <h3 class="font-bold text-[17px] text-black text-center">{{ $cat['label'] }}</h3>
                        <p class="text-[#666] mt-2">{{ $count }} Propriedades</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>


    {{-- ======================================================
    IMÓVEIS EM DESTAQUE
    ====================================================== --}}
    <section class="py-24 bg-[#F7F7F7]">
        <div class="w-full max-w-7xl mx-auto px-4 lg:px-6">

            <div class="w-full max-w-7xl mx-auto mb-12 px-4  lg:px-6 flex flex-row items-center justify-between">
                <div>
                    <span class="text-[#F97316] text-lg font-semibold uppercase">
                        {{ $sections['featured']['tag'] ?? 'Propriedades' }}
                    </span>
                    <h2 class="mt-3 text-xl md:text-4xl font-bold">
                        {{ $sections['featured']['title'] ?? 'Imóveis em Destaque' }}
                    </h2>
                </div>
                <a href="{{ url('/imoveis') }}"
                    class="bg-[#F97316] text-center hover:bg-[#F97316]/80 px-6 text-sm py-3 w-[160px] rounded-md transition duration-300 text-white">
                    {{ $sections['featured']['button_text'] ?? 'Ver Mais' }}
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php  $count=0 ?>
                @forelse($featured as $imovel)
                 <?php $count++; ?>
                   @if ($count != 3)
                   <article
                        class="property-card cursor-pointer bg-white rounded-[20px] overflow-hidden border border-[#E5E5E5] shadow-lg"
                        onclick="window.location.href='{{ route('properties.show', $imovel) }}'"
                        >
                        <div class="relative">
                            @if($imovel->image && file_exists(public_path('assets/' . $imovel->image)))
                                <img src="{{ asset('assets/' . $imovel->image) }}" alt="{{ $imovel->title }}"
                                    class="w-full h-[260px] object-cover">
                            @elseif($imovel->image && str_starts_with($imovel->image, 'properties/'))
                                <img src="{{ Storage::url($imovel->image) }}" alt="{{ $imovel->title }}"
                                    class="w-full h-[260px] object-cover">
                            @else
                                <img src="{{ asset('assets/1.jpeg') }}" alt="{{ $imovel->title }}"
                                    class="w-full h-[260px] object-cover">
                            @endif
                            <span class="absolute top-4 left-4 text-xs font-bold px-3 py-2 rounded-lg"
                                style="background-color: {{ $imovel->type === 'arrendamento' ? '#FFD166' : '#F97316' }}; color: {{ $imovel->type === 'arrendamento' ? 'black' : 'white' }}">
                                {{ strtoupper($imovel->type) }}
                            </span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold leading-tight">{{ $imovel->title }}</h3>
                            <p class="text-[#999] mt-3">{{ $imovel->location }}</p>
                            <div class="py-5 mt-5">
                                <div class="grid grid-cols-2 gap-4">
                                    @if($imovel->bedrooms > 0)
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-zinc-500 "  translate="no">domain</span>
                                            <span>{{ $imovel->bedrooms }} Quarto{{ $imovel->bedrooms > 1 ? 's' : '' }}</span>
                                        </div>
                                    @endif
                                    @if($imovel->bathrooms > 0)
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-zinc-500"  translate="no">shower</span>
                                            <span>{{ $imovel->bathrooms }} WC</span>
                                        </div>
                                    @endif
                                    @if($imovel->garages > 0)
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-zinc-500"  translate="no">directions_car</span>
                                            <span>{{ $imovel->garages }} Garagem{{ $imovel->garages > 1 ? 's' : '' }}</span>
                                        </div>
                                    @endif
                                    @if($imovel->area)
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-zinc-500"  translate="no">square_foot</span>
                                            <span>{{ $imovel->area }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-6 gap-2">
                                <h4 class="text-[#F97316] text-lg font-bold">{{ $imovel->price }}</h4>
                                <a href="{{ route('properties.show', $imovel) }}" class="bg-[#F97316] text-center text-white text-[12px] px-6 py-3 rounded-md
                                          uppercase tracking-wider font-semibold hover:bg-[#e65100] transition w-[160px]">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </article>
                   @endif
                    
                @empty
                    <div class="col-span-3 text-center py-16 text-gray-400">
                        <p>Nenhum imóvel em destaque de momento.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>


    {{-- ======================================================
    O QUE NÓS FAZEMOS
    ====================================================== --}}
    <section class="py-24 bg-white">
        <div class="w-full max-w-7xl mx-auto px-4 lg:px-6">
            <div class="mb-20">
                <span class="text-[#F97316] text-lg font-semibold uppercase">
                    {{ $sections['services']['tag'] ?? 'Sobre' }}
                </span>
                <h2 class="mt-3 text-2xl lg:text-4xl font-bold">
                    {{ $sections['services']['title'] ?? 'O que nós fazemos' }}
                </h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-2 cursor-pointer">
                @php
                    $srvList = [
                        [
                            'icon' => 'real_estate_agent',
                            'title' => $sections['services']['srv_1_title'] ?? 'Parceria com proprietários',
                            'desc' => $sections['services']['srv_1_desc'] ?? 'Cuidamos do seu imóvel como se fosse nosso. Manutenção, ocupação e valorização contínua, com total tranquilidade para o proprietário.',
                        ],
                        [
                            'icon' => 'home_work',
                            'title' => $sections['services']['srv_2_title'] ?? 'Avaliação Imobiliária',
                            'desc' => $sections['services']['srv_2_desc'] ?? 'Encontramos o imóvel certo para si, ou o comprador/inquilino certo para o seu imóvel, com acompanhamento em cada etapa.',
                        ],
                        [
                            'icon' => 'analytics',
                            'title' => $sections['services']['srv_3_title'] ?? 'Consultoria para investidores',
                            'desc' => $sections['services']['srv_3_desc'] ?? 'Apoio especializado para quem quer investir com segurança no mercado imobiliário angolano.',
                        ],
                        [
                            'icon' => 'account_balance',
                            'title' => $sections['services']['srv_4_title'] ?? 'Gestão de património',
                            'desc' => $sections['services']['srv_4_desc'] ?? 'Identificamos oportunidades com elevado potencial de valorização para quem quer investir em Angola.',
                        ],
                    ];
                @endphp
                @foreach($srvList as $srv)
                    <div class="service-card h-full min-h-[220px] p-8 border border-[#ddd]">
                        <span class="material-symbols-outlined text-[50px] text-black mb-6 block"  translate="no">
                            {{ $srv['icon'] }}
                        </span>
                        <h3 class="text-xl font-bold mb-5">{{ $srv['title'] }}</h3>
                        <p class="text-lg leading-relaxed text-[#333]">{{ $srv['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- ======================================================
    SWIPER — IMÓVEIS INTERNACIONAIS EM DESTAQUE
    ====================================================== --}}
    <section class="py-24 bg-white">
        <div class="w-full max-w-7xl mx-auto mb-12 px-4 gap-1  lg:px-6 flex flex-row items-center justify-between">
            <div>
                <span class="text-[#F97316] text-lg font-semibold uppercase">
                    {{ $sections['international']['tag'] ?? 'Propriedades' }}
                </span>
                <h2 class="mt-3 text-xl md:text-4xl font-bold">
                    {{ $sections['international']['title'] ?? 'Imóveis Internacionais em Destaque' }}
                </h2>
            </div>
            <a href="{{ url('/imoveis') }}"
                class="bg-[#F97316] text-center hover:bg-[#F97316]/80 px-6 text-sm py-3 w-[160px] rounded-md transition duration-300 text-white">
                {{ $sections['international']['button_text'] ?? 'Ver Mais' }}
            </a>
        </div>

        <div class="w-full mx-auto px-4 lg:px-6 relative">
            <div class="swiper featuredSwiper">
                <div class="swiper-wrapper">
                    @php
                        $sliderProps = \App\Models\Property::where('is_active', true)
                            ->where('is_featured', true)
                            ->where('country', '!=', 'Angola')
                            ->latest()
                            ->take(6)
                            ->get();
                    @endphp
                    @foreach($sliderProps as $slide)
                        <div class="swiper-slide">
                            <a href="{{ route('properties.show', $slide) }}"
                                class="group relative h-[560px] rounded-[30px] overflow-hidden block shadow-lg">
                                @if($slide->image && file_exists(public_path('assets/' . $slide->image)))
                                    <img src="{{ asset('assets/' . $slide->image) }}" alt="{{ $slide->title }}"
                                        class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                @elseif($slide->image && str_starts_with($slide->image, 'properties/'))
                                    <img src="{{ Storage::url($slide->image) }}" alt="{{ $slide->title }}"
                                        class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                @else
                                    <img src="{{ asset('assets/1.jpeg') }}" alt="{{ $slide->title }}"
                                        class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent">
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 p-8 z-10">
                                    <span
                                        class="bg-[#F97316] text-white text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">
                                        {{ $slide->type }}
                                    </span>
                                    <h3 class="text-white text-xl font-bold leading-tight">{{ $slide->title }}</h3>
                                    <p class="text-white/80 mt-2 text-sm flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]"  translate="no">location_on</span>
                                        {{ $slide->location }}
                                    </p>
                                    <div class="mt-4">
                                        <span class="text-white text-2xl font-bold">
                                            {{ $slide->price }}
                                            @if($slide->price_period)
                                                <span
                                                    class="text-sm font-normal text-white/70">{{ $slide->price_period }}</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="swiper-pagination flex justify-center h-10 mt-[30px]"></div>
        </div>
    </section>


    {{-- ======================================================
    CTA BANNER
    ====================================================== --}}
    <section class="bg-[#F7F7F7] pt-20 pb-0 mb-10">
        <div class="w-full max-w-7xl mx-auto px-4 lg:px-6">
            <div class="bg-[#F97316] rounded-[32px] py-20 px-8 lg:px-20 text-center">
                <h2 class="text-white text-4xl lg:text-6xl font-bold leading-tight">
                    {{ $sections['cta']['title'] ?? 'Encontre o imóvel ideal para si' }}
                </h2>
                <p class="text-white/90 text-xl lg:text-2xl mt-6 max-w-4xl mx-auto">
                    {{ $sections['cta']['subtitle'] ?? 'Descubra oportunidades exclusivas de compra, venda e arrendamento em Luanda e nas principais cidades de Angola.' }}
                </p>
                <div class="mt-10">
                    <a href="{{ url('/imoveis') }}" class="inline-flex items-center px-8 py-4 bg-white text-[#F97316]
                              rounded-xl font-bold uppercase tracking-wider hover:scale-105 transition">
                        {{ $sections['cta']['button_text'] ?? 'Ver Imóveis' }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- SWIPER Script --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                new Swiper('.featuredSwiper', {
                    slidesPerView: 1.1,
                    spaceBetween: 20,
                    pagination: { el: '.swiper-pagination', clickable: true },
                    breakpoints: {
                        640: { slidesPerView: 1.5, spaceBetween: 24 },
                        1024: { slidesPerView: 2.5, spaceBetween: 30 },
                    }
                });
            });
        </script>
    @endpush

</x-layouts.app>