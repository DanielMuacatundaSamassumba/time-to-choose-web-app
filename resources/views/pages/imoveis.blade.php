<x-layouts.app title="Imóveis" description="Arrendamento de curta e longa duração, compra e venda de imóveis premium em Angola, Portugal e África do Sul.">

    {{-- =============================================
         BARRA DE PESQUISA & FILTROS
    ============================================= --}}
    <div class="px-3 flex justify-center mt-12">
        <div class="w-full max-w-7xl bg-orange-500 rounded-2xl p-6 shadow-2xl"
             x-data="{
                open: {{ request()->anyFilled(['typology', 'country', 'city']) ? 'true' : 'false' }},

                country: '{{ request('country', '') }}',
                city: '{{ request('city', '') }}',
                propertyType: '{{ request('property_type', '') }}',
                typology: '{{ request('typology', '') }}',

                /* ── País → Cidades ── */
                cityMap: {
                    'Angola':       ['Luanda','Benguela','Lubango','Cabinda','Malanje','Namibe','Huambo','Soyo','Saurimo'],
                    'Portugal':     ['Lisboa','Porto','Faro','Braga','Coimbra','Setúbal','Aveiro','Évora','Funchal'],
                    'África do Sul':['Pretória','Joanesburgo','Cidade do Cabo','Durban','East London','Bloemfontein','Port Elizabeth']
                },
                get cities() {
                    return this.country ? (this.cityMap[this.country] ?? []) : [];
                },

                /* ── Tipo de Imóvel → Tipologia ── */
                get typologyPrefix() {
                    if (this.propertyType === 'vivenda') return 'V';
                    return 'T';
                },
                get isTerrain() {
                    return this.propertyType === 'terreno';
                },
                get isCommercial() {
                    return ['escritório','loja'].includes(this.propertyType);
                },
                get showTypology() {
                    return !this.isTerrain && !this.isCommercial;
                },
                get typologyNumbers() {
                    return [0,1,2,3,4,5];
                },

                /* Reset city when country changes */
                onCountryChange() {
                    this.city = '';
                }
             }">

            <form id="filter-form" action="{{ route('properties.index') }}" method="GET">

                {{-- ── LINHA 1: Filtros Principais ── --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    {{-- Pesquisa --}}
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Pesquisar título, zona, cidade..."
                           class="h-14 rounded-xl px-5 outline-none text-sm text-gray-800 placeholder-gray-400 col-span-1 sm:col-span-2 lg:col-span-1">

                    {{-- Tipo de Negócio --}}
                    <select name="type"
                            class="h-14 rounded-xl px-5 outline-none text-sm text-gray-600 cursor-pointer">
                        <option value="">Tipo de Negócio</option>
                        <option value="arrendamento" @selected(request('type') === 'arrendamento')>Arrendamento</option>
                        <option value="venda"        @selected(request('type') === 'venda')>Venda</option>
                    </select>

                    {{-- Tipo de Imóvel --}}
                    <select name="property_type"
                            x-model="propertyType"
                            class="h-14 rounded-xl px-5 outline-none text-sm text-gray-600 cursor-pointer">
                        <option value="">Tipo de Imóvel</option>
                        @foreach(['apartamento'=>'Apartamento','vivenda'=>'Vivenda','moradia'=>'Moradia','escritório'=>'Escritório','loja'=>'Loja','terreno'=>'Terreno'] as $val => $label)
                            <option value="{{ $val }}" @selected(request('property_type') === $val)>{{ $label }}</option>
                        @endforeach
                    </select>

                    {{-- Botão Filtros + Pesquisar --}}
                    <div class="flex items-center gap-3">
                        <button type="button" @click="open = !open"
                                class="flex items-center justify-center gap-2 text-white border border-white/60 rounded-xl px-4 h-14 hover:bg-white/10 transition shrink-0"
                                title="Filtros avançados">
                            <span class="material-symbols-outlined text-[22px] transition-transform duration-300"
                                  :class="open ? 'rotate-180' : ''">tune</span>
                        </button>
                        <button type="submit"
                                class="flex-1 h-14 rounded-xl bg-white text-orange-600 uppercase tracking-widest text-sm font-bold hover:bg-orange-50 transition duration-300">
                            Pesquisar
                        </button>
                    </div>
                </div>

                {{-- ── LINHA 2: Filtros Avançados (colapsável) ── --}}
                <div x-show="open" x-cloak x-collapse>
                    <div class="border-t border-white/30 my-5"></div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                        {{-- País --}}
                        <div>
                            <label class="block text-white/80 text-xs font-semibold uppercase tracking-wider mb-2">País</label>
                            <select name="country"
                                    x-model="country"
                                    @change="onCountryChange()"
                                    class="w-full h-14 rounded-xl px-4 text-sm text-gray-600 outline-none cursor-pointer">
                                <option value="">Todos os Países</option>
                                <template x-for="(cities, c) in cityMap" :key="c">
                                    <option :value="c" :selected="country === c" x-text="c"></option>
                                </template>
                            </select>
                        </div>

                        {{-- Cidade (dinâmica conforme País) --}}
                        <div>
                            <label class="block text-white/80 text-xs font-semibold uppercase tracking-wider mb-2">Cidade</label>
                            <select name="city"
                                    x-model="city"
                                    class="w-full h-14 rounded-xl px-4 text-sm text-gray-600 outline-none cursor-pointer">
                                <option value="">
                                    <span x-text="country ? 'Selecionar cidade' : 'Todas as Cidades'"></span>
                                </option>
                                <template x-if="!country">
                                    {{-- Sem país selecionado: mostra todas as cidades disponíveis na DB --}}
                                    @foreach($cities as $c)
                                    <option value="{{ $c }}" @selected(request('city') === $c)>{{ $c }}</option>
                                    @endforeach
                                </template>
                                <template x-if="country">
                                    {{-- Com país selecionado: mostra cidades do Alpine cityMap --}}
                                    <template x-for="c in cities" :key="c">
                                        <option :value="c" :selected="city === c" x-text="c"></option>
                                    </template>
                                </template>
                            </select>
                        </div>

                        {{-- Tipologia (dinâmica conforme Tipo de Imóvel) --}}
                        <div>
                            <label class="block text-white/80 text-xs font-semibold uppercase tracking-wider mb-2">
                                <span x-text="isTerrain ? 'Área (m²)' : isCommercial ? 'Área' : 'Tipologia'"></span>
                            </label>

                            {{-- Apartamento / Vivenda / Moradia → T0..T6+ ou V1..V6+ --}}
                            <template x-if="showTypology">
                                <select name="typology"
                                        x-model="typology"
                                        class="w-full h-14 rounded-xl px-4 text-sm text-gray-600 outline-none cursor-pointer">
                                    <option value="" x-text="'Todas as Tipologias'"></option>
                                    <template x-for="n in typologyNumbers" :key="n">
                                        <option :value="n"
                                                :selected="typology == n"
                                                x-text="typologyPrefix + n"></option>
                                    </template>
                                    <option :value="'6+'"
                                            :selected="typology === '6+'"
                                            x-text="typologyPrefix + '6+'"></option>
                                </select>
                            </template>

                            {{-- Terreno → faixas de área --}}
                            <template x-if="isTerrain">
                                <select name="typology"
                                        x-model="typology"
                                        class="w-full h-14 rounded-xl px-4 text-sm text-gray-600 outline-none cursor-pointer">
                                    <option value="">Qualquer Área</option>
                                    <option value="200"  :selected="typology === '200'" >Até 200 m²</option>
                                    <option value="500"  :selected="typology === '500'" >Até 500 m²</option>
                                    <option value="1000" :selected="typology === '1000'">Até 1.000 m²</option>
                                    <option value="2000" :selected="typology === '2000'">Até 2.000 m²</option>
                                    <option value="5000" :selected="typology === '5000'">Até 5.000 m²</option>
                                </select>
                            </template>

                            {{-- Escritório / Loja → sem tipologia (área livre) --}}
                            <template x-if="isCommercial">
                                <select name="typology"
                                        x-model="typology"
                                        class="w-full h-14 rounded-xl px-4 text-sm text-gray-600 outline-none cursor-pointer">
                                    <option value="">Qualquer Dimensão</option>
                                    <option value="50"   :selected="typology === '50'"  >Até 50 m²</option>
                                    <option value="100"  :selected="typology === '100'" >Até 100 m²</option>
                                    <option value="250"  :selected="typology === '250'" >Até 250 m²</option>
                                    <option value="500"  :selected="typology === '500'" >Até 500 m²</option>
                                    <option value="1000" :selected="typology === '1000'">Até 1.000 m²</option>
                                </select>
                            </template>
                        </div>

                        {{-- Limpar filtros --}}
                        <div class="flex items-end">
                            <a href="{{ route('properties.index') }}"
                               class="w-full h-14 rounded-xl border border-white text-white text-sm font-semibold
                                      hover:bg-white hover:text-orange-500 transition flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">filter_alt_off</span>
                                Limpar Filtros
                            </a>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- =============================================
         CHIPS DE FILTROS ACTIVOS
    ============================================= --}}
    @if(request()->anyFilled(['search','type','property_type','country','city','typology']))
    <div class="max-w-7xl mx-auto px-4 lg:px-6 mt-6">
        <div class="flex flex-wrap gap-2 items-center">
            <span class="text-sm text-gray-500 font-medium mr-1">Filtros activos:</span>
            @foreach(['search' => 'Pesquisa', 'type' => 'Negócio', 'property_type' => 'Tipo', 'country' => 'País', 'city' => 'Cidade', 'typology' => 'Tipologia'] as $param => $label)
                @if(request()->filled($param))
                <a href="{{ request()->fullUrlWithoutQuery([$param]) }}"
                   class="inline-flex items-center gap-1.5 bg-orange-100 text-orange-700 text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-orange-200 transition">
                    {{ $label }}: {{ ucfirst(request($param)) }}
                    <span class="material-symbols-outlined text-[14px]">close</span>
                </a>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- =============================================
         LISTAGEM DE IMÓVEIS
    ============================================= --}}
    <section class="py-10">
        <div class="max-w-7xl mx-auto px-4 lg:px-6">

            {{-- Header da listagem --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        {{ $properties->total() }}
                        imóv{{ $properties->total() === 1 ? 'el encontrado' : 'eis encontrados' }}
                    </h1>
                    <p class="text-gray-400 text-sm mt-1">
                        @if(request('country'))
                            {{ request('country') }}@if(request('city')) · {{ request('city') }}@endif
                        @else
                            Angola · Portugal · África do Sul
                        @endif
                        @if(request('type')) · {{ ucfirst(request('type')) }}@endif
                    </p>
                </div>

                {{-- Ordenar --}}
                <form action="{{ route('properties.index') }}" method="GET" id="sort-form">
                    @foreach(request()->except(['sort','page']) as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                    <select name="sort" onchange="document.getElementById('sort-form').submit()"
                            class="h-12 rounded-xl border border-gray-200 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 cursor-pointer">
                        <option value="recentes"    @selected(request('sort','recentes') === 'recentes')  >Mais recentes</option>
                        <option value="preco_baixo" @selected(request('sort') === 'preco_baixo')>Menor preço</option>
                        <option value="preco_alto"  @selected(request('sort') === 'preco_alto') >Maior preço</option>
                    </select>
                </form>
            </div>

            {{-- Grid de cards --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($properties as $property)

                @php
                    $pt = strtolower($property->property_type);
                    if ($pt === 'vivenda') {
                        $badge = 'V' . $property->bedrooms;
                    } elseif (in_array($pt, ['terreno'])) {
                        $badge = $property->area ?? '—';
                    } elseif (in_array($pt, ['escritório','escritorio','loja'])) {
                        $badge = $property->area ?? ucfirst($pt);
                    } else {
                        $badge = 'T' . $property->bedrooms;
                    }
                @endphp

                <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col group">

                    {{-- Imagem --}}
                    <div class="relative overflow-hidden h-[240px] shrink-0">
                        <img src="{{ $property->image_url }}" alt="{{ $property->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">

                        {{-- Badge negócio --}}
                        <span class="absolute top-3 left-3 text-[11px] font-bold px-3 py-1.5 rounded-lg uppercase tracking-wide shadow"
                              style="background:{{ $property->type === 'arrendamento' ? '#FFD166' : '#FF5A00' }};
                                     color:{{ $property->type === 'arrendamento' ? '#333' : '#fff' }}">
                            {{ $property->type }}
                        </span>

                        {{-- Badge tipologia --}}
                        <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-bold px-3 py-1.5 rounded-lg shadow">
                            {{ $badge }}
                        </span>

                        {{-- País + Cidade --}}
                        <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/65 to-transparent px-4 py-3">
                            <p class="text-white/90 text-xs flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">location_on</span>
                                {{ $property->city }}, {{ $property->country }}
                            </p>
                        </div>
                    </div>

                    {{-- Conteúdo --}}
                    <div class="p-5 flex flex-col flex-1">
                        <h2 class="text-base font-bold text-gray-900 leading-snug group-hover:text-orange-500 transition line-clamp-2">
                            {{ $property->title }}
                        </h2>
                        <p class="text-gray-400 text-xs mt-1">{{ ucfirst($property->property_type) }}</p>

                        {{-- Atributos --}}
                        <div class="mt-4 grid grid-cols-2 gap-x-4 gap-y-2 text-xs text-gray-500 border-t border-b border-gray-100 py-4">
                            @if($property->bedrooms > 0 && !in_array($pt, ['terreno','loja','escritório','escritorio']))
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[17px] text-orange-400">bed</span>
                                <span>{{ $property->bedrooms }} Quarto{{ $property->bedrooms > 1 ? 's' : '' }}</span>
                            </div>
                            @endif
                            @if($property->bathrooms > 0)
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[17px] text-orange-400">shower</span>
                                <span>{{ $property->bathrooms }} WC</span>
                            </div>
                            @endif
                            @if($property->garages > 0)
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[17px] text-orange-400">directions_car</span>
                                <span>{{ $property->garages }} Garagem</span>
                            </div>
                            @endif
                            @if($property->area)
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[17px] text-orange-400">square_foot</span>
                                <span>{{ $property->area }}</span>
                            </div>
                            @endif
                        </div>

                        {{-- Preço + Botão --}}
                        <div class="flex items-end justify-between mt-4 gap-2">
                            <div>
                                <p class="text-orange-500 text-lg font-bold leading-tight">{{ $property->price }}</p>
                                @if($property->price_period)
                                    <p class="text-gray-400 text-xs">{{ $property->price_period }}</p>
                                @endif
                            </div>
                            <a href="{{ route('properties.show', $property) }}"
                               class="bg-orange-500 text-white text-xs font-bold px-5 py-2.5 rounded-xl uppercase tracking-wider hover:bg-orange-600 transition whitespace-nowrap">
                                Ver Detalhes
                            </a>
                        </div>
                    </div>
                </article>

                @empty
                <div class="col-span-3 text-center py-24">
                    <span class="material-symbols-outlined text-7xl text-gray-200 mb-4 block">search_off</span>
                    <p class="text-xl font-semibold text-gray-400">Nenhum imóvel encontrado.</p>
                    <p class="text-sm text-gray-400 mt-1">Tente remover ou alterar os filtros seleccionados.</p>
                    <a href="{{ route('properties.index') }}"
                       class="mt-8 inline-flex items-center gap-2 bg-orange-500 text-white px-7 py-3 rounded-xl font-bold hover:bg-orange-600 transition">
                        <span class="material-symbols-outlined text-[18px]">refresh</span>
                        Ver Todos os Imóveis
                    </a>
                </div>
                @endforelse
            </div>

            {{-- Paginação --}}
            @if($properties->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $properties->links() }}
            </div>
            @endif

        </div>
    </section>

</x-layouts.app>