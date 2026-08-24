<x-layouts.app
    :title="$sections['seo']['title'] ?? 'Imóveis em Luanda'"
    :description="$sections['seo']['description'] ?? 'Arrendamento de curta e longa duração, compra e venda de imóveis premium em Angola, Portugal e África do Sul.'">

    {{-- =============================================
    BARRA DE PESQUISA & FILTROS
    ============================================= --}}
    <div class="px-3 flex justify-center mt-12">
        <div class="w-full max-w-7xl bg-[#F97316] rounded-2xl p-6 shadow-2xl" x-data="{
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

                    {{-- Tipo de Negócio / Categoria --}}
                    <select name="category" class="h-14 rounded-xl px-5 outline-none text-sm text-gray-600 cursor-pointer">
                        <option value="">Tipo de Negócio</option>
                        <option value="venda" @selected(request('category') === 'venda')>Venda</option>
                        <option value="arrendamento-longa-duracao" @selected(request('category') === 'arrendamento-longa-duracao')>
                            Arrendamento de Longa Duração</option>
                        <option value="arrendamento-curta-duracao" @selected(request('category') === 'arrendamento-curta-duracao')>
                            Arrendamento de Curta Duração</option>
                        <option value="transpasse" @selected(request('category') === 'transpasse')>
                            Transpasse</option>
                    </select>

                    {{-- Tipo de Imóvel --}}
                    <select name="property_type" x-model="propertyType"
                        class="h-14 rounded-xl px-5 outline-none text-sm text-gray-600 cursor-pointer">
                        <option value="">Tipo de Imóvel</option>
                        @foreach(['apartamento' => 'Apartamento', 'vivenda' => 'Vivenda', "espaços_comerciais" => "Espaços Comercias", "terrenos"=>'terrenos'] as $val => $label)
                            <option value="{{ $val }}" @selected(request('property_type') === $val)>{{ $label }}</option>
                        @endforeach
                    </select>

                    {{-- Botão Filtros + Pesquisar --}}
                    <div class="flex items-center gap-3">
                        <button type="button" @click="open = !open"
                            class="flex items-center justify-center gap-2 text-white border border-white/60 rounded-xl px-4 h-14 hover:bg-white/10 transition shrink-0"
                            title="Filtros avançados">
                            <span class="material-symbols-outlined text-[22px] transition-transform duration-300" 
                                :class="open ? 'rotate-180' : ''" translate="no">tune</span>
                        </button>
                        <button type="submit"
                            class="flex-1 h-14 rounded-xl bg-white text-[#F97316]/90 uppercase tracking-widest text-sm font-bold transition duration-300">
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
                            <label
                                class="block text-white/80 text-xs font-semibold uppercase tracking-wider mb-2">País</label>
                            <select name="country" x-model="country" @change="onCountryChange()"
                                class="w-full h-14 rounded-xl px-4 text-sm text-gray-600 outline-none cursor-pointer">
                                <option value="">Todos os Países</option>
                                <template x-for="(cities, c) in cityMap" :key="c">
                                    <option :value="c" :selected="country === c" x-text="c"></option>
                                </template>
                            </select>
                        </div>

                        {{-- Cidade (dinâmica conforme País) --}}
                        <div>
                            <label
                                class="block text-white/80 text-xs font-semibold uppercase tracking-wider mb-2">Cidade</label>
                            <select name="city" x-model="city"
                                class="w-full h-14 rounded-xl px-4 text-sm text-gray-600 outline-none cursor-pointer">
                                <option value="">
                                    <span x-text="country ? 'Selecionar cidade' : 'Todas as Cidades'"></span>
                                </option>
                                <template x-if="!country">
                                    <optgroup label="Cidades">
                                        @foreach($cities as $c)
                                            <option value="{{ $c }}" @selected(request('city') === $c)>{{ $c }}</option>
                                        @endforeach
                                    </optgroup>
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
                                <select name="typology" x-model="typology"
                                    class="w-full h-14 rounded-xl px-4 text-sm text-gray-600 outline-none cursor-pointer">
                                    <option value="" x-text="'Todas as Tipologias'"></option>
                                    <template x-for="n in typologyNumbers" :key="n">
                                        <option :value="n" :selected="typology == n" x-text="typologyPrefix + n">
                                        </option>
                                    </template>
                                    <option :value="'6+'" :selected="typology === '6+'" x-text="typologyPrefix + '6+'">
                                    </option>
                                </select>
                            </template>

                            {{-- Terreno → faixas de área --}}
                            <template x-if="isTerrain">
                                <select name="typology" x-model="typology"
                                    class="w-full h-14 rounded-xl px-4 text-sm text-gray-600 outline-none cursor-pointer">
                                    <option value="">Qualquer Área</option>
                                    <option value="200" :selected="typology === '200'">Até 200 m²</option>
                                    <option value="500" :selected="typology === '500'">Até 500 m²</option>
                                    <option value="1000" :selected="typology === '1000'">Até 1.000 m²</option>
                                    <option value="2000" :selected="typology === '2000'">Até 2.000 m²</option>
                                    <option value="5000" :selected="typology === '5000'">Até 5.000 m²</option>
                                </select>
                            </template>

                            {{-- Escritório / Loja → sem tipologia (área livre) --}}
                            <template x-if="isCommercial">
                                <select name="typology" x-model="typology"
                                    class="w-full h-14 rounded-xl px-4 text-sm text-gray-600 outline-none cursor-pointer">
                                    <option value="">Qualquer Dimensão</option>
                                    <option value="50" :selected="typology === '50'">Até 50 m²</option>
                                    <option value="100" :selected="typology === '100'">Até 100 m²</option>
                                    <option value="250" :selected="typology === '250'">Até 250 m²</option>
                                    <option value="500" :selected="typology === '500'">Até 500 m²</option>
                                    <option value="1000" :selected="typology === '1000'">Até 1.000 m²</option>
                                </select>
                            </template>
                        </div>

                        {{-- Limpar filtros --}}
                        <div class="flex items-end">
                            <a href="{{ route('properties.index') }}"
                                class="w-full h-14 rounded-xl border border-white text-white text-sm font-semibold
                                      hover:bg-white hover:text-[#F97316] transition flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[18px]" translate="no">filter_alt_off</span>
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
   @if(request()->anyFilled(['search', 'category', 'property_type', 'country', 'city', 'typology']))
    <div class="max-w-7xl mx-auto px-4 lg:px-6 mt-6">
        <div class="flex flex-wrap gap-2 items-center">
            <span class="text-sm text-gray-500 font-medium mr-1">
                Filtros activos:
            </span>

            @foreach([
                'search' => 'Pesquisa',
                'category' => 'Categoria',
                'property_type' => 'Tipo',
                'country' => 'País',
                'city' => 'Cidade',
                'typology' => 'Tipologia'
            ] as $param => $label)

                @if(request()->filled($param))
                    <a href="{{ request()->fullUrlWithoutQuery([$param]) }}"
                        class="inline-flex items-center gap-1.5 bg-[#F97316]/10 text-[#F97316]/80 text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-[#F97316]/20 transition">

                        {{ $label }}:
                        {{ ucfirst(str_replace('-', ' ', request($param))) }}

                        <span class="material-symbols-outlined text-[14px]" translate="no">
                            close
                        </span>
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
        <div class="max-w-7xl mx-auto px-4 lg:px-6" x-data="infiniteScroll({
            nextUrl: '{{ $properties->nextPageUrl() ? parse_url($properties->nextPageUrl(), PHP_URL_PATH) . '?' . parse_url($properties->nextPageUrl(), PHP_URL_QUERY) : '' }}',
            hasMore: {{ $properties->hasMorePages() ? 'true' : 'false' }}
        })">

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
                    @foreach(request()->except(['sort', 'page']) as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                    <select name="sort" onchange="document.getElementById('sort-form').submit()"
                        class="h-12 rounded-xl border border-gray-200 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#F97316] cursor-pointer">
                        <option value="recentes" @selected(request('sort', 'recentes') === 'recentes')>Mais recentes
                        </option>
                        <option value="preco_baixo" @selected(request('sort') === 'preco_baixo')>Menor preço</option>
                        <option value="preco_alto" @selected(request('sort') === 'preco_alto')>Maior preço</option>
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
                        } elseif (in_array($pt, ['escritório', 'escritorio', 'loja'])) {
                            $badge = $property->area ?? ucfirst($pt);
                        } else {
                            $badge = 'T' . $property->bedrooms;
                        }
                    @endphp

                    <article
                    onclick="window.location.href='{{ route('properties.show', $property) }}'"
                        class="bg-white cursor-pointer rounded-2xl overflow-hidden border border-gray-100 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col group">

                        {{-- Imagem --}}
                        <div class="relative overflow-hidden h-[240px] shrink-0">
                            <img src="{{ $property->image_url }}" alt="{{ $property->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">

                            {{-- Badge negócio --}}
                            <span
                                class="absolute top-3 left-3 text-[11px] font-bold px-3 py-1.5 rounded-lg uppercase tracking-wide shadow"
                                style="background:{{ $property->type === 'arrendamento' ? '#FFD166' : '#F97316' }};
                                                     color:{{ $property->type === 'arrendamento' ? '#333' : '#fff' }}">
                                {{ $property->type }}
                            </span>

                            {{-- Badge tipologia --}}
                            <span
                                class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-bold px-3 py-1.5 rounded-lg shadow">
                                {{ $badge }}
                            </span>

                            {{-- País + Cidade --}}
                            <div
                                class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/65 to-transparent px-4 py-3">
                                <p class="text-white/90 text-xs flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]" translate="no">location_on</span>
                                    {{ $property->city }}, {{ $property->country }}
                                </p>
                            </div>
                        </div>

                        {{-- Conteúdo --}}
                        <div class="p-5 flex flex-col flex-1">
                            <h2
                                class="text-base font-bold text-gray-900 leading-snug group-hover:text-[#F97316] transition line-clamp-2">
                                {{ $property->title }}
                            </h2>
                            <p class="text-gray-400 text-xs mt-1">{{ ucfirst($property->property_type) }}</p>

                            {{-- Atributos --}}
                            <div
                                class="mt-4 grid grid-cols-2 gap-x-4 gap-y-2 text-xs text-gray-500 border-t border-b border-gray-100 py-4">
                                @if($property->bedrooms > 0 && !in_array($pt, ['terreno', 'loja', 'escritório', 'escritorio']))
                                    <div class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[17px] text-[#F97316]" translate="no">bed</span>
                                        <span>{{ $property->bedrooms }} Quarto{{ $property->bedrooms > 1 ? 's' : '' }}</span>
                                    </div>
                                @endif
                                @if($property->bathrooms > 0)
                                    <div class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[17px] text-[#F97316]" translate="no">shower</span>
                                        <span>{{ $property->bathrooms }} WC</span>
                                    </div>
                                @endif
                                @if($property->garages > 0)
                                    <div class="flex items-center gap-1.5">
                                        <span
                                            class="material-symbols-outlined text-[17px] text-[#F97316]" translate="no">directions_car</span>
                                        <span>{{ $property->garages }} Garagem</span>
                                    </div>
                                @endif
                                @if($property->area)
                                    <div class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[17px] text-[#F97316]" translate="no">square_foot</span>
                                        <span>{{ $property->area }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Preço + Botão --}}
                            <div class="flex items-end justify-between mt-4 gap-2">
                                <div>
                                    <p class="text-[#F97316] text-lg font-bold leading-tight">{{ $property->price }}</p>
                                    @if($property->price_period)
                                        <p class="text-gray-400 text-xs">{{ $property->price_period }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('properties.show', $property) }}"
                                    class="bg-[#F97316] text-white text-xs font-bold px-5 py-2.5 rounded-xl uppercase tracking-wider hover:bg-[#F97316]/90 transition whitespace-nowrap">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </article>

                @empty
                    <div class="col-span-3 text-center py-24">
                        <span class="material-symbols-outlined text-7xl text-gray-200 mb-4 block" translate="no">search_off</span>
                        <p class="text-xl font-semibold text-gray-400">Nenhum imóvel encontrado.</p>
                        <p class="text-sm text-gray-400 mt-1">Tente remover ou alterar os filtros seleccionados.</p>
                        <a href="{{ route('properties.index') }}"
                            class="mt-8 inline-flex items-center gap-2 bg-[#F97316] text-white px-7 py-3 rounded-xl font-bold hover:bg-[#F97316]/90 transition">
                            <span class="material-symbols-outlined text-[18px]" translate="no">refresh</span>
                            Ver Todos os Imóveis
                        </a>
                    </div>
                @endforelse

                {{-- Dynamic items loaded via infinite scroll --}}
                <template x-for="p in extraProperties" :key="p.id">
                    <article
                        class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col group">

                        {{-- Imagem --}}
                        <div class="relative overflow-hidden h-[240px] shrink-0">
                            <img :src="p.image_url" :alt="p.title"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">

                            {{-- Badge negócio --}}
                            <span
                                class="absolute top-3 left-3 text-[11px] font-bold px-3 py-1.5 rounded-lg uppercase tracking-wide shadow"
                                :style="p.type === 'arrendamento' ? 'background: #FFD166; color: #333;' : 'background: #F97316; color: #fff;'">
                                <span x-text="p.type"></span>
                            </span>

                            {{-- Badge tipologia --}}
                            <span
                                class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-bold px-3 py-1.5 rounded-lg shadow"
                                x-text="getBadge(p)">
                            </span>

                            {{-- País + Cidade --}}
                            <div
                                class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/65 to-transparent px-4 py-3">
                                <p class="text-white/90 text-xs flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]" translate="no">location_on</span>
                                    <span x-text="p.city + ', ' + p.country"></span>
                                </p>
                            </div>
                        </div>

                        {{-- Conteúdo --}}
                        <div class="p-5 flex flex-col flex-1">
                            <h2 class="text-base font-bold text-gray-900 leading-snug group-hover:text-[#F97316] transition line-clamp-2"
                                x-text="p.title">
                            </h2>
                            <p class="text-gray-400 text-xs mt-1" x-text="p.property_type_label"></p>

                            {{-- Atributos --}}
                            <div
                                class="mt-4 grid grid-cols-2 gap-x-4 gap-y-2 text-xs text-gray-500 border-t border-b border-gray-100 py-4">
                                <template
                                    x-if="p.bedrooms > 0 && !['terreno', 'loja', 'escritório', 'escritorio'].includes(p.property_type)">
                                    <div class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[17px] text-[#F97316]" translate="no">bed</span>
                                        <span x-text="p.bedrooms + ' Quarto' + (p.bedrooms > 1 ? 's' : '')"></span>
                                    </div>
                                </template>
                                <template x-if="p.bathrooms > 0">
                                    <div class="flex items-center gap-1.5">
                                        <span
                                            class="material-symbols-outlined text-[17px] text-[#F97316]" translate="no">shower</span>
                                        <span x-text="p.bathrooms + ' WC'"></span>
                                    </div>
                                </template>
                                <template x-if="p.garages > 0">
                                    <div class="flex items-center gap-1.5">
                                        <span
                                            class="material-symbols-outlined text-[17px] text-[#F97316]" translate="no">directions_car</span>
                                        <span x-text="p.garages + ' Garagem'"></span>
                                    </div>
                                </template>
                                <template x-if="p.area">
                                    <div class="flex items-center gap-1.5">
                                        <span
                                            class="material-symbols-outlined text-[17px] text-[#F97316]" translate="no">square_foot</span>
                                        <span x-text="p.area"></span>
                                    </div>
                                </template>
                            </div>

                            {{-- Preço + Botão --}}
                            <div class="flex items-end justify-between mt-4 gap-2">
                                <div>
                                    <p class="text-[#F97316] text-lg font-bold leading-tight" x-text="p.price"></p>
                                    <template x-if="p.price_period">
                                        <p class="text-gray-400 text-xs" x-text="p.price_period"></p>
                                    </template>
                                </div>
                                <a :href="p.url"
                                    class="bg-[#F97316] text-white text-xs font-bold px-5 py-2.5 rounded-xl uppercase tracking-wider hover:bg-[#F97316]/90 transition whitespace-nowrap">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </article>
                </template>
            </div>

            {{-- Skeleton Loading Grid --}}
            <div x-show="isLoading" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-8" x-cloak>
                <template x-for="i in [1, 2, 3]">
                    <div
                        class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-md flex flex-col animate-pulse">
                        {{-- Image Skeleton --}}
                        <div class="bg-gray-200 h-[240px] w-full relative">
                            <div class="absolute top-3 left-3 bg-gray-300 h-6 w-20 rounded-lg"></div>
                            <div class="absolute top-3 right-3 bg-gray-300 h-6 w-12 rounded-lg"></div>
                            <div class="absolute bottom-3 left-4 bg-gray-300 h-4 w-40 rounded"></div>
                        </div>
                        {{-- Content Skeleton --}}
                        <div class="p-5 flex flex-col flex-1 space-y-3">
                            <div class="h-5 bg-gray-250 rounded w-5/6"></div>
                            <div class="h-5 bg-gray-250 rounded w-2/3"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/4 mt-1"></div>
                            <div class="border-t border-gray-150 my-4 pt-4 grid grid-cols-2 gap-4">
                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                <div class="h-4 bg-gray-200 rounded w-2/3"></div>
                            </div>
                            <div class="flex justify-between items-end pt-2">
                                <div class="space-y-2">
                                    <div class="h-6 bg-gray-200 rounded w-24"></div>
                                    <div class="h-3 bg-gray-150 rounded w-16"></div>
                                </div>
                                <div class="h-10 bg-gray-200 rounded-xl w-32"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Elemento sensor para o scroll infinito --}}
            <div x-ref="trigger"
                :class="hasMore ? 'h-16 w-full mt-8 flex items-center justify-center' : 'h-0 w-full overflow-hidden'"
                x-cloak>
                <template x-if="hasMore && !isLoading">
                    <div class="flex flex-col items-center gap-2">
                        <span class="text-xs text-gray-400 uppercase tracking-widest font-semibold animate-pulse">
                            A carregar mais imóveis...
                        </span>
                        {{-- Spinner icon --}}
                        <svg class="animate-spin h-5 w-5 text-[#F97316]" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </template>
            </div>

            {{-- Paginação clássica (só aparece se JavaScript estiver desativado para manter SEO do Google Crawler) --}}
            <div x-show="false" class="mt-12 flex justify-center">
                @if($properties->hasPages())
                    {{ $properties->links() }}
                @endif
            </div>

        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('infiniteScroll', (config) => ({
                    nextUrl: config.nextUrl,
                    hasMore: config.hasMore,
                    extraProperties: [],
                    isLoading: false,
                    isTriggerIntersecting: false,

                    init() {
                        if (!this.hasMore) return;

                        const observer = new IntersectionObserver((entries) => {
                            this.isTriggerIntersecting = entries[0].isIntersecting;
                            if (this.isTriggerIntersecting && !this.isLoading && this.hasMore) {
                                this.loadMore();
                            }
                        }, {
                            rootMargin: '300px'
                        });

                        this.$nextTick(() => {
                            if (this.$refs.trigger) {
                                observer.observe(this.$refs.trigger);
                            }
                        });
                    },

                    async loadMore() {
                        if (this.isLoading || !this.nextUrl || !this.hasMore) return;

                        this.isLoading = true;
                        try {
                            const fetchUrl = this.nextUrl + (this.nextUrl.includes('?') ? '&' : '?') + 'ajax=1';
                            const response = await fetch(fetchUrl, {
                                headers: {
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            });

                            if (!response.ok) throw new Error('Falha ao carregar imóveis.');

                            const data = await response.json();

                            // Filter out duplicates just in case (e.g. if new items were added while browsing)
                            const existingIds = new Set(this.extraProperties.map(p => p.id));
                            const newItems = data.properties.filter(p => !existingIds.has(p.id));

                            this.extraProperties.push(...newItems);
                            this.hasMore = data.hasMore;
                            this.nextUrl = data.nextPageUrl;
                        } catch (error) {
                            console.error('Erro ao carregar mais imóveis:', error);
                        } finally {
                            this.isLoading = false;

                            // If the trigger element is still in view (e.g., high resolution screen or empty space),
                            // load the next batch immediately to fill the view.
                            this.$nextTick(() => {
                                if (this.isTriggerIntersecting && this.hasMore && !this.isLoading) {
                                    this.loadMore();
                                }
                            });
                        }
                    },

                    getBadge(p) {
                        const pt = p.property_type.toLowerCase();
                        if (pt === 'vivenda') {
                            return 'V' + p.bedrooms;
                        } else if (pt === 'terreno') {
                            return p.area || '—';
                        } else if (['escritório', 'escritorio', 'loja'].includes(pt)) {
                            return p.area || p.property_type_label;
                        } else {
                            return 'T' + p.bedrooms;
                        }
                    }
                }));
            });
        </script>

        @if(session('error') || session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
                x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed bottom-5 right-5 z-50 max-w-sm w-full bg-white border-l-4 {{ session('error') ? 'border-red-500' : 'border-green-500' }} rounded-xl shadow-2xl p-4 flex items-start gap-3 pointer-events-auto border border-gray-150"
                role="alert" x-cloak>

                {{-- Icon --}}
                <div class="flex-shrink-0 mt-0.5">
                    @if(session('error'))
                        <span class="material-symbols-outlined text-red-500 text-[20px] font-bold" translate="no">error</span>
                    @else
                        <span class="material-symbols-outlined text-green-500 text-[20px] font-bold" translate="no">check_circle</span>
                    @endif
                </div>

                {{-- Content --}}
                <div class="flex-1">
                    <p class="text-xs font-bold text-gray-900 uppercase tracking-wider">
                        {{ session('error') ? 'Aviso' : 'Sucesso' }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1 font-medium leading-relaxed">
                        {{ session('error') ?? session('success') }}
                    </p>
                </div>

                {{-- Close Button --}}
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition flex-shrink-0">
                    <span class="material-symbols-outlined text-[16px] font-bold" translate="no">close</span>
                </button>
            </div>
        @endif
    @endpush
</x-layouts.app>