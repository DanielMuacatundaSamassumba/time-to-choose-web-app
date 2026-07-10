<x-layouts.app title="Página Inicial" :headerTransparent="true">

    {{-- ======================================================
         HERO SECTION
    ====================================================== --}}
    <section class="relative h-[700px] lg:h-[650px] overflow-visible">

        {{-- Video --}}
        <video autoplay muted loop playsinline preload="auto"
               class="absolute inset-0 w-full h-full object-cover z-0">
            <source src="https://xamariz.ao/wp-content/uploads/revslider/slider-11/videoplayback.mp4" type="video/mp4">
        </video>

        {{-- Overlay --}}
        <div class="absolute inset-0 bg-black/50 z-10"></div>

        {{-- HERO CONTENT --}}
        <div class="relative z-20 h-full flex items-center justify-center">
            <div class="text-center px-6 max-w-5xl">
                <h1 class="text-white font-bold leading-tight text-4xl md:text-6xl lg:text-7xl">
                    Viver bem em Luanda <br/> é uma escolha.
                </h1>
                <p class="text-white/90 mt-6 text-lg md:text-xl">
                    Mais de 200 imóveis premium em Luanda com o acompanhamento que merece
                </p>
            </div>
        </div>

        {{-- SEARCH BAR --}}
        <div class="p-3">
            <div x-data="{ open: false }"
                 class="relative -mt-40
                        lg:absolute lg:left-1/2 lg:-translate-x-1/2 lg:bottom-[-40px]
                        w-full max-w-7xl
                        bg-orange-500 rounded-2xl shadow-2xl p-6 z-30">

                <form action="{{ route('properties.index') }}" method="GET">
                    {{-- ROW 1 --}}
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                        <input type="text" name="search"
                               placeholder="Pesquisar cidade, título ou zona..."
                               class="h-14 rounded-xl px-5 outline-none text-sm text-gray-800 placeholder-gray-400">

                        <select name="type" class="h-14 rounded-xl px-5 outline-none text-sm text-gray-500 cursor-pointer">
                            <option value="">Tipo de Negócio</option>
                            <option value="arrendamento">Arrendamento</option>
                            <option value="venda">Venda</option>
                        </select>

                        <select name="property_type" id="hp_property_type"
                                class="h-14 rounded-xl px-5 outline-none text-sm text-gray-500 cursor-pointer">
                            <option value="">Tipo de Imóvel</option>
                            <option value="apartamento">Apartamento</option>
                            <option value="vivenda">Vivenda</option>
                            <option value="moradia">Moradia</option>
                            <option value="escritório">Escritório</option>
                            <option value="loja">Loja</option>
                            <option value="terreno">Terreno</option>
                        </select>

                        <div class="flex items-center gap-3">
                            <button type="button" @click="open=!open"
                                    class="flex items-center gap-2 text-white border border-white/70 rounded-xl px-4 py-3 hover:bg-white/10 transition shrink-0">
                                <span class="material-symbols-outlined transition duration-300"
                                      :class="open ? 'rotate-180' : ''">tune</span>
                            </button>
                            <button type="submit"
                                    class="flex-1 h-14 rounded-xl bg-white text-orange-600 uppercase tracking-wider text-sm
                                           font-bold hover:bg-orange-50 transition duration-300">
                                Pesquisar
                            </button>
                        </div>
                    </div>

                    {{-- ROW 2: Filtros expandidos --}}
                    <div x-show="open" x-cloak x-collapse class="overflow-hidden">
                        <div class="border-t border-white/30 my-5"></div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                            <select name="country" class="h-14 rounded-xl px-5 text-sm text-gray-500 outline-none cursor-pointer">
                                <option value="">Todos os Países</option>
                                <option value="Angola">Angola</option>
                                <option value="Portugal">Portugal</option>
                                <option value="África do Sul">África do Sul</option>
                            </select>

                            <select name="city" class="h-14 rounded-xl px-5 text-sm text-gray-500 outline-none cursor-pointer">
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
                                    if (this.pt === 'terreno') return 'm²';
                                    return 'T';
                                }
                            }" x-init="() => { document.getElementById('hp_property_type').addEventListener('change', e => pt = e.target.value) }">
                                <select name="typology" class="h-14 rounded-xl px-5 text-sm text-gray-500 outline-none w-full cursor-pointer">
                                    <option value="">Tipologia</option>
                                    <template x-for="n in [0,1,2,3,4,5]" :key="n">
                                        <option :value="n" x-text="prefix + n"></option>
                                    </template>
                                    <option :value="'6+'" x-text="prefix + '6+'"></option>
                                </select>
                            </div>

                            <div class="flex justify-end">
                                <button type="reset"
                                        class="h-14 px-6 rounded-xl border border-white text-white text-sm font-semibold
                                               hover:bg-white hover:text-orange-500 transition w-full">
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
                    <span class="text-[#FF5A00] text-sm md:text-base lg:text-lg font-semibold uppercase">
                        TIPOS DE PROPRIEDADES
                    </span>
                    <h2 class="mt-3 text-3xl md:text-4xl lg:text-4xl font-bold">
                        Encontre o seu lugar em Luanda
                    </h2>
                </div>
            </div>

            @php
                $categories = [
                    ['label' => 'Apartamentos',       'type' => 'apartamento'],
                    ['label' => 'Vivendas',            'type' => 'vivenda'],
                    ['label' => 'Escritórios',         'type' => 'escritório'],
                    ['label' => 'Outros',              'type' => null],
                ];
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-center justify-center w-full">
                @foreach($categories as $cat)
                @php
                    $q = \App\Models\Property::where('is_active', true);
                    if ($cat['type']) $q->where('property_type', $cat['type']);
                    $count = $q->count();
                @endphp
                <a href="{{ url('/imoveis') . ($cat['type'] ? '?property_type=' . $cat['type'] : '') }}"
                   class="category-card bg-white rounded-[24px] border border-[#DADADA]
                          h-[190px] p-3 flex flex-col items-center justify-center
                          shadow-[0_8px_0_#FF5A00] hover:-translate-y-2 transition-all duration-300">
                    <div class="w-20 h-20 rounded-full bg-[#FAD38D] flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-[#FF5A00]"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-5h6v5M9 10h2m4 0h2m-8 4h2m4 0h2"/>
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
                <span class="text-[#FF5A00] text-lg font-semibold uppercase">Propriedades</span>
                <h2 class="mt-3 text-xl md:text-4xl font-bold">Imóveis em Destaque</h2>
            </div>
            <a href="{{ url('/imoveis') }}"
               class="bg-[#FF5A00] text-center hover:bg-[#FF5A00]/80 px-6 text-sm py-3 w-[160px] rounded-md transition duration-300 text-white">
                Ver Mais
            </a>
        </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse($featured as $imovel)
                <article class="property-card bg-white rounded-[20px] overflow-hidden border border-[#E5E5E5] shadow-lg">
                    <div class="relative">
                        @if($imovel->image && file_exists(public_path('assets/' . $imovel->image)))
                            <img src="{{ asset('assets/' . $imovel->image) }}" alt="{{ $imovel->title }}" class="w-full h-[260px] object-cover">
                        @elseif($imovel->image && str_starts_with($imovel->image, 'properties/'))
                            <img src="{{ Storage::url($imovel->image) }}" alt="{{ $imovel->title }}" class="w-full h-[260px] object-cover">
                        @else
                            <img src="{{ asset('assets/1.jpeg') }}" alt="{{ $imovel->title }}" class="w-full h-[260px] object-cover">
                        @endif
                        <span class="absolute top-4 left-4 text-xs font-bold px-3 py-2 rounded-lg"
                              style="background-color: {{ $imovel->type === 'arrendamento' ? '#FFD166' : '#FF5A00' }}; color: {{ $imovel->type === 'arrendamento' ? 'black' : 'white' }}">
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
                                    <span class="material-symbols-outlined text-zinc-500">domain</span>
                                    <span>{{ $imovel->bedrooms }} Quarto{{ $imovel->bedrooms > 1 ? 's' : '' }}</span>
                                </div>
                                @endif
                                @if($imovel->bathrooms > 0)
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-zinc-500">shower</span>
                                    <span>{{ $imovel->bathrooms }} WC</span>
                                </div>
                                @endif
                                @if($imovel->garages > 0)
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-zinc-500">directions_car</span>
                                    <span>{{ $imovel->garages }} Garagem{{ $imovel->garages > 1 ? 's' : '' }}</span>
                                </div>
                                @endif
                                @if($imovel->area)
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-zinc-500">square_foot</span>
                                    <span>{{ $imovel->area }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-6 gap-2">
                            <h4 class="text-[#FF5A00] text-lg font-bold">{{ $imovel->price }}</h4>
                            <a href="{{ route('properties.show', $imovel) }}"
                               class="bg-[#F97316] text-center text-white text-[12px] px-6 py-3 rounded-md
                                      uppercase tracking-wider font-semibold hover:bg-[#e65100] transition w-[160px]">
                                Ver Detalhes
                            </a>
                        </div>
                    </div>
                </article>
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
                <span class="text-[#FF5A00] text-lg font-semibold uppercase">Sobre</span>
                <h2 class="mt-3 text-2xl lg:text-4xl font-bold">O que nós fazemos</h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-2 cursor-pointer">
                @foreach([
                    ['icon' => 'real_estate_agent', 'title' => 'Parceria com proprietários',
                     'desc' => 'Cuidamos do seu imóvel como se fosse nosso. Manutenção, ocupação e valorização contínua, com total tranquilidade para o proprietário.'],
                    ['icon' => 'home_work', 'title' => 'Avaliação Imobiliária',
                     'desc' => 'Encontramos o imóvel certo para si, ou o comprador/inquilino certo para o seu imóvel, com acompanhamento em cada etapa.'],
                    ['icon' => 'analytics', 'title' => 'Consultoria para investidores',
                     'desc' => 'Apoio especializado para quem quer investir com segurança no mercado imobiliário angolano.'],
                    ['icon' => 'account_balance', 'title' => 'Gestão de património',
                     'desc' => 'Identificamos oportunidades com elevado potencial de valorização para quem quer investir em Angola.'],
                ] as $srv)
                <div class="service-card h-full min-h-[220px] p-8 border border-[#ddd]">
                    <span class="material-symbols-outlined text-[50px] text-black mb-6 block">
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
                <span class="text-[#FF5A00] text-lg font-semibold uppercase">Propriedades</span>
                <h2 class="mt-3 text-xl md:text-4xl font-bold">Imóveis Internacionais em Destaque</h2>
            </div>
            <a href="{{ url('/imoveis') }}"
               class="bg-[#FF5A00] text-center hover:bg-[#FF5A00]/80 px-6 text-sm py-3 w-[160px] rounded-md transition duration-300 text-white">
                Ver Mais
            </a>
        </div>

        <div class="w-full mx-auto px-4 lg:px-6 relative">
            <div class="swiper featuredSwiper">
                <div class="swiper-wrapper">
                    @php
                        $sliderProps = \App\Models\Property::where('is_active', true)
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
                                <img src="{{ asset('assets/' . $slide->image) }}" alt="{{ $slide->title }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                            @elseif($slide->image && str_starts_with($slide->image, 'properties/'))
                                <img src="{{ Storage::url($slide->image) }}" alt="{{ $slide->title }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                            @else
                                <img src="{{ asset('assets/1.jpeg') }}" alt="{{ $slide->title }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-8 z-10">
                                <span class="bg-orange-500 text-white text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">
                                    {{ $slide->type }}
                                </span>
                                <h3 class="text-white text-xl font-bold leading-tight">{{ $slide->title }}</h3>
                                <p class="text-white/80 mt-2 text-sm flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">location_on</span>
                                    {{ $slide->location }}
                                </p>
                                <div class="mt-4">
                                    <span class="text-white text-2xl font-bold">
                                        {{ $slide->price }}
                                        @if($slide->price_period)
                                            <span class="text-sm font-normal text-white/70">{{ $slide->price_period }}</span>
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
    <section class="bg-[#F7F7F7] pt-20 pb-0">
        <div class="w-full max-w-7xl mx-auto px-4 lg:px-6">
            <div class="bg-[#F97316] rounded-[32px] py-20 px-8 lg:px-20 text-center">
                <h2 class="text-white text-4xl lg:text-6xl font-bold leading-tight">
                    Encontre o imóvel ideal para si
                </h2>
                <p class="text-white/90 text-xl lg:text-2xl mt-6 max-w-4xl mx-auto">
                    Descubra oportunidades exclusivas de compra, venda e arrendamento
                    em Luanda e nas principais cidades de Angola.
                </p>
                <div class="mt-10">
                    <a href="{{ url('/imoveis') }}"
                       class="inline-flex items-center px-8 py-4 bg-white text-[#FF5A00]
                              rounded-xl font-bold uppercase tracking-wider hover:scale-105 transition">
                        Ver Imóveis
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
                640:  { slidesPerView: 1.5, spaceBetween: 24 },
                1024: { slidesPerView: 2.5, spaceBetween: 30 },
            }
        });
    });
    </script>
    @endpush

</x-layouts.app>