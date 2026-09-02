<x-admin.layout :title="'Ficha Técnica — ' . $property->title" :breadcrumb="'Imóveis / Ficha Técnica #' . str_pad($property->id, 4, '0', STR_PAD_LEFT)">

    <x-slot name="styles">
        <style>
            @media print {
                aside, nav, header, .no-print, #admin-sidebar, button, .print-hidden {
                    display: none !important;
                }
                body, main, .admin-main-content {
                    background: white !important;
                    color: black !important;
                    padding: 0 !important;
                    margin: 0 !important;
                    width: 100% !important;
                }
                .print-card {
                    border: 1px solid #e5e7eb !important;
                    box-shadow: none !important;
                    page-break-inside: avoid;
                }
                .print-header {
                    display: block !important;
                }
            }
        </style>
    </x-slot>

    <div class="space-y-6 max-w-6xl mx-auto pb-12" x-data="{ selectedImg: '{{ $property->image ? (file_exists(public_path('assets/' . $property->image)) ? asset('assets/' . $property->image) : (str_starts_with($property->image, 'properties/') ? Storage::url($property->image) : asset('assets/' . $property->image))) : '' }}' }">

        {{-- Top Bar & Actions --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 no-print">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.properties.index') }}"
                   class="w-10 h-10 rounded-sm bg-white border border-admin-border flex items-center justify-center text-admin-muted hover:text-admin-text hover:border-brand transition shadow-sm">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        Ficha Técnica do Imóvel
                        <span class="text-xs font-mono font-semibold bg-gray-100 text-gray-600 px-2.5 py-0.5 rounded-sm border border-gray-200">
                            #TTC-{{ str_pad($property->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </h1>
                    <p class="text-xs text-admin-muted mt-0.5">Cadastrado em {{ $property->created_at?->format('d/m/Y \à\s H:i') }} &bull; Atualizado em {{ $property->updated_at?->format('d/m/Y \à\s H:i') }}</p>
                </div>
            </div>

            <div class="flex items-center flex-wrap gap-2.5">
                <button onclick="window.print()"
                        class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 text-xs font-bold px-4 py-2.5 rounded-sm shadow-sm flex items-center gap-2 transition">
                    <i class="fa-solid fa-print text-sm text-gray-500"></i>
                    Imprimir / PDF
                </button>

                <a href="{{ route('properties.show', $property) }}" target="_blank"
                   class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 text-xs font-bold px-4 py-2.5 rounded-sm shadow-sm flex items-center gap-2 transition">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs text-brand"></i>
                    Ver no Site
                </a>

                <a href="{{ route('admin.properties.edit', $property) }}"
                   class="bg-brand hover:bg-brand-dark text-white text-xs font-bold px-5 py-2.5 rounded-sm shadow-sm flex items-center gap-2 transition">
                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                    Editar Imóvel
                </a>
            </div>
        </div>

        {{-- Main Overview Card --}}
        <div class="bg-white rounded-sm border border-admin-border overflow-hidden shadow-sm print-card">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">
                {{-- Media column (Gallery & Preview) --}}
                <div class="lg:col-span-5 bg-gray-900 p-6 flex flex-col justify-between relative min-h-[340px]">
                    <div class="relative w-full h-72 rounded-sm overflow-hidden bg-black/40 border border-white/10 flex items-center justify-center">
                        <template x-if="selectedImg">
                            <img :src="selectedImg" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!selectedImg">
                            <div class="text-center text-gray-400 p-6">
                                <i class="fa-solid fa-image text-4xl mb-2"></i>
                                <p class="text-xs">Sem fotografia principal</p>
                            </div>
                        </template>
                    </div>

                    {{-- Mini thumbnails --}}
                    @php
                        $allImages = [];
                        if ($property->image) {
                            $allImages[] = file_exists(public_path('assets/' . $property->image))
                                ? asset('assets/' . $property->image)
                                : (str_starts_with($property->image, 'properties/') ? Storage::url($property->image) : asset('assets/' . $property->image));
                        }
                        if (!empty($property->gallery) && is_array($property->gallery)) {
                            foreach ($property->gallery as $gImg) {
                                $allImages[] = file_exists(public_path('assets/' . $gImg))
                                    ? asset('assets/' . $gImg)
                                    : (str_starts_with($gImg, 'properties/') ? Storage::url($gImg) : asset('assets/' . $gImg));
                            }
                        }
                    @endphp

                    @if(count($allImages) > 1)
                    <div class="flex items-center gap-2 mt-4 overflow-x-auto pb-1 no-print">
                        @foreach($allImages as $idx => $imgSrc)
                        <button type="button" @click="selectedImg = '{{ $imgSrc }}'"
                                :class="selectedImg === '{{ $imgSrc }}' ? 'ring-2 ring-brand' : 'opacity-60 hover:opacity-100'"
                                class="w-14 h-11 rounded-sm overflow-hidden flex-shrink-0 border border-white/20 transition">
                            <img src="{{ $imgSrc }}" class="w-full h-full object-cover">
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Key Information Column --}}
                <div class="lg:col-span-7 p-6 lg:p-8 flex flex-col justify-between space-y-6">
                    <div>
                        {{-- Badges Row --}}
                        <div class="flex items-center flex-wrap gap-2 mb-3">
                            {{-- Business Badge --}}
                            @if($property->category === 'arrendamento-longa-duracao')
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                    <i class="fa-solid fa-key text-[10px] mr-1"></i> Longa Duração
                                </span>
                            @elseif($property->category === 'arrendamento-curta-duracao')
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                    <i class="fa-solid fa-bolt text-[10px] mr-1"></i> Curta Duração
                                </span>
                            @elseif($property->category === 'transpasse')
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-purple-50 text-purple-700 border border-purple-200">
                                    <i class="fa-solid fa-right-left text-[10px] mr-1"></i> Transpasse
                                </span>
                            @else
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-orange-50 text-[#F97316] border border-orange-200">
                                    <i class="fa-solid fa-tag text-[10px] mr-1"></i> Venda
                                </span>
                            @endif

                            {{-- Property Type --}}
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-gray-100 text-gray-700 border border-gray-200">
                                {{ $property->property_type_label }}
                            </span>

                            {{-- Land Classification --}}
                            @if($property->land_type_label)
                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    <i class="fa-solid fa-mountain-sun text-[10px] mr-1"></i> {{ $property->land_type_label }}
                                </span>
                            @endif

                            {{-- Status --}}
                            @php
                                $statusStyles = [
                                    'disponivel' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'reservado'  => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'arrendado'  => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'vendido'    => 'bg-red-50 text-red-700 border-red-200',
                                ];
                            @endphp
                            <span class="text-xs font-bold px-3 py-1 rounded-full border {{ $statusStyles[$property->status] ?? 'bg-gray-50 text-gray-700' }}">
                                {{ ucfirst($property->status) }}
                            </span>

                            {{-- Visibility --}}
                            @if($property->is_active)
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center gap-1">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i> Visível ao Público
                                </span>
                            @else
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200 flex items-center gap-1">
                                    <i class="fa-solid fa-eye-slash text-[10px]"></i> Oculto do Site
                                </span>
                            @endif

                            @if($property->is_featured)
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-700 border border-yellow-200 flex items-center gap-1">
                                    <i class="fa-solid fa-star text-[10px] text-yellow-500"></i> Em Destaque
                                </span>
                            @endif
                        </div>

                        {{-- Title --}}
                        <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                            {{ $property->title }}
                        </h2>

                        {{-- Location --}}
                        <p class="text-sm text-gray-500 mt-2 flex items-center gap-1.5">
                            <i class="fa-solid fa-location-dot text-brand"></i>
                            <span>{{ $property->location ?: $property->city }}</span> &bull;
                            <span class="font-medium text-gray-700">{{ $property->city }}, {{ $property->country }}</span>
                        </p>

                        {{-- Price Box --}}
                        <div class="mt-5 p-4 rounded-sm bg-orange-50/70 border border-orange-200 flex items-center justify-between">
                            <div>
                                <span class="text-[11px] uppercase font-bold text-gray-500 tracking-wider">Valor Solicitado</span>
                                <div class="text-2xl font-black text-brand">
                                    {{ $property->price }}
                                    @if($property->price_period)
                                        <span class="text-sm font-normal text-gray-600">{{ $property->price_period }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-11 h-11 rounded-sm bg-brand text-white flex items-center justify-center font-bold text-lg shadow-sm">
                                <i class="fa-solid fa-coins"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Specs Row --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 border-t border-gray-100">
                        <div class="p-3 bg-gray-50 rounded-sm border border-gray-100 text-center">
                            <i class="fa-solid fa-shapes text-brand mb-1 text-sm"></i>
                            <p class="text-[10px] text-gray-400 uppercase font-semibold">Tipologia</p>
                            <p class="text-sm font-bold text-gray-800">{{ $property->typology_display }}</p>
                        </div>
                        @if(str_contains(strtolower((string) $property->property_type), 'terren'))
                        <div class="p-3 bg-emerald-50 rounded-sm border border-emerald-200 text-center">
                            <i class="fa-solid fa-mountain-sun text-emerald-600 mb-1 text-sm"></i>
                            <p class="text-[10px] text-emerald-500 uppercase font-semibold">Classificação</p>
                            <p class="text-sm font-bold text-emerald-800">{{ $property->land_type_label ?: '—' }}</p>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-sm border border-emerald-200 text-center col-span-2">
                            <i class="fa-solid fa-ruler-combined text-emerald-600 mb-1 text-sm"></i>
                            <p class="text-[10px] text-emerald-500 uppercase font-semibold">Área / Dimensão</p>
                            <p class="text-sm font-bold text-emerald-800">{{ $property->area ?: 'N/D' }}</p>
                        </div>
                        @else
                        <div class="p-3 bg-gray-50 rounded-sm border border-gray-100 text-center">
                            <i class="fa-solid fa-bed text-brand mb-1 text-sm"></i>
                            <p class="text-[10px] text-gray-400 uppercase font-semibold">Quartos</p>
                            <p class="text-sm font-bold text-gray-800">{{ $property->bedrooms ?: '0' }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-sm border border-gray-100 text-center">
                            <i class="fa-solid fa-shower text-brand mb-1 text-sm"></i>
                            <p class="text-[10px] text-gray-400 uppercase font-semibold">Casas de Banho</p>
                            <p class="text-sm font-bold text-gray-800">{{ $property->bathrooms ?: '0' }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-sm border border-gray-100 text-center">
                            <i class="fa-solid fa-ruler-combined text-brand mb-1 text-sm"></i>
                            <p class="text-[10px] text-gray-400 uppercase font-semibold">Área</p>
                            <p class="text-sm font-bold text-gray-800">{{ $property->area ?: 'N/D' }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== TERRENO: Características Específicas ===== --}}
        @if(str_contains(strtolower((string) $property->property_type), 'terren'))
        <div class="bg-emerald-50/60 rounded-sm border border-emerald-200 p-6 shadow-sm print-card">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
                    <div class="w-8 h-8 rounded-sm bg-emerald-600 text-white flex items-center justify-center">
                        <i class="fa-solid fa-mountain-sun text-sm"></i>
                    </div>
                    Características do Terreno
                </h3>
                @if($property->land_type_label)
                <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300">
                    {{ $property->land_type_label }}
                </span>
                @endif
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                {{-- Classificação --}}
                <div class="bg-white p-4 rounded-sm border border-emerald-200/80 shadow-sm text-center">
                    <i class="fa-solid fa-layer-group text-emerald-600 text-xl mb-2"></i>
                    <p class="text-[10px] text-gray-400 uppercase font-semibold mb-1">Classificação</p>
                    <p class="text-sm font-bold text-gray-900">
                        {{ $property->land_type_label ?: '— Não definida —' }}
                    </p>
                </div>
                {{-- Área / Dimensão --}}
                <div class="bg-white p-4 rounded-sm border border-emerald-200/80 shadow-sm text-center">
                    <i class="fa-solid fa-ruler-combined text-emerald-600 text-xl mb-2"></i>
                    <p class="text-[10px] text-gray-400 uppercase font-semibold mb-1">Área / Dimensão</p>
                    <p class="text-sm font-bold text-gray-900">
                        {{ $property->area ?: '— Não definida —' }}
                    </p>
                </div>
                {{-- Tipo de Imóvel --}}
                <div class="bg-white p-4 rounded-sm border border-emerald-200/80 shadow-sm text-center">
                    <i class="fa-solid fa-map text-emerald-600 text-xl mb-2"></i>
                    <p class="text-[10px] text-gray-400 uppercase font-semibold mb-1">Tipo de Imóvel</p>
                    <p class="text-sm font-bold text-gray-900">
                        {{ $property->property_type_label }}
                    </p>
                </div>
            </div>
            @if($property->land_type)
            <div class="mt-4 p-3 bg-white border border-emerald-200 rounded-sm text-xs text-gray-600 flex items-start gap-2">
                <i class="fa-solid fa-circle-info text-emerald-500 mt-0.5 shrink-0"></i>
                <span>
                    Este terreno está classificado como
                    <strong class="text-emerald-700">{{ $property->land_type_label }}</strong>.
                    @if($property->area) Dimensão total: <strong>{{ $property->area }}</strong>. @endif
                    A classificação determina a filtragem no site público e os filtros de pesquisa.
                </span>
            </div>
            @endif
        </div>
        @endif

        {{-- CONFIDENTIAL: Dados do Proprietário --}}
        <div class="bg-amber-50/60 rounded-sm border border-amber-200 p-6 shadow-sm print-card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
                    <div class="w-8 h-8 rounded-sm bg-amber-500 text-white flex items-center justify-center">
                        <i class="fa-solid fa-user-shield text-sm"></i>
                    </div>
                    Dados do Proprietário
                    <span class="text-[11px] font-semibold text-amber-800 bg-amber-100 border border-amber-300 px-2.5 py-0.5 rounded-full">
                        <i class="fa-solid fa-lock text-[10px] mr-1"></i>Uso Interno e Confidencial
                    </span>
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Owner Name --}}
                <div class="bg-white p-4 rounded-sm border border-amber-200/80 shadow-2xs">
                    <p class="text-xs text-gray-500 font-semibold uppercase">Nome do Proprietário</p>
                    <p class="text-sm font-bold text-gray-900 mt-1">
                        {{ $property->owner_name ?: '— Não registado —' }}
                    </p>
                </div>

                {{-- Owner Phone --}}
                <div class="bg-white p-4 rounded-sm border border-amber-200/80 shadow-2xs">
                    <p class="text-xs text-gray-500 font-semibold uppercase">Telefone</p>
                    @if($property->owner_phone)
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $property->owner_phone) }}"
                           class="text-sm font-bold text-brand hover:underline mt-1 inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-phone text-xs"></i>
                            {{ $property->owner_phone }}
                        </a>
                    @else
                        <p class="text-sm font-normal text-gray-400 mt-1">— Não registado —</p>
                    @endif
                </div>

                {{-- Owner WhatsApp --}}
                <div class="bg-white p-4 rounded-sm border border-amber-200/80 shadow-2xs">
                    <p class="text-xs text-gray-500 font-semibold uppercase">WhatsApp</p>
                    @if($property->owner_whatsapp)
                        @php
                            $waClean = preg_replace('/[^0-9]/', '', $property->owner_whatsapp);
                        @endphp
                        <a href="https://wa.me/{{ $waClean }}" target="_blank"
                           class="text-sm font-bold text-emerald-600 hover:underline mt-1 inline-flex items-center gap-1.5">
                            <i class="fa-brands fa-whatsapp text-sm text-emerald-500"></i>
                            {{ $property->owner_whatsapp }}
                        </a>
                    @else
                        <p class="text-sm font-normal text-gray-400 mt-1">— Não registado —</p>
                    @endif
                </div>

                {{-- Owner Email --}}
                <div class="bg-white p-4 rounded-sm border border-amber-200/80 shadow-2xs">
                    <p class="text-xs text-gray-500 font-semibold uppercase">E-mail</p>
                    @if($property->owner_email)
                        <a href="mailto:{{ $property->owner_email }}"
                           class="text-sm font-bold text-blue-600 hover:underline mt-1 inline-flex items-center gap-1.5 truncate block"
                           title="{{ $property->owner_email }}">
                            <i class="fa-solid fa-envelope text-xs"></i>
                            {{ $property->owner_email }}
                        </a>
                    @else
                        <p class="text-sm font-normal text-gray-400 mt-1">— Não registado —</p>
                    @endif
                </div>
            </div>

            @if($property->owner_website)
            <div class="mt-3 bg-white p-3.5 rounded-sm border border-amber-200/80 text-xs flex items-center gap-2">
                <i class="fa-solid fa-globe text-gray-400"></i>
                <span class="font-semibold text-gray-500">Website / Link:</span>
                <a href="{{ $property->owner_website }}" target="_blank" class="text-brand hover:underline font-mono">
                    {{ $property->owner_website }}
                </a>
            </div>
            @endif
        </div>

        {{-- Description & Features Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left column: Description --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Description Card --}}
                <div class="bg-white rounded-sm border border-admin-border p-6 shadow-sm print-card">
                    <h3 class="font-bold text-gray-900 text-base mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-align-left text-brand"></i>
                        Descrição Detalhada do Imóvel
                    </h3>
                    <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-line bg-gray-50/50 p-5 rounded-sm border border-gray-100">
                        {{ $property->description ?: 'Sem descrição detalhada adicionada.' }}
                    </div>
                </div>

                {{-- Amenities Card --}}
                <div class="bg-white rounded-sm border border-admin-border p-6 shadow-sm print-card">
                    <h3 class="font-bold text-gray-900 text-base mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-brand"></i>
                        Comodidades & Equipamentos
                    </h3>
                    @if(!empty($property->amenities) && is_array($property->amenities))
                        <div class="flex flex-wrap gap-2.5">
                            @foreach($property->amenities as $amenity)
                            <span class="bg-gray-50 border border-gray-200 text-gray-800 text-xs font-semibold px-3 py-1.5 rounded-sm flex items-center gap-1.5">
                                <i class="fa-solid fa-circle-check text-brand text-xs"></i>
                                {{ $amenity }}
                            </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-gray-400">Nenhuma comodidade especificada.</p>
                    @endif
                </div>
            </div>

            {{-- Right column: Location & Links --}}
            <div class="space-y-6">
                {{-- Detailed Location Card --}}
                <div class="bg-white rounded-sm border border-admin-border p-6 shadow-sm print-card">
                    <h3 class="font-bold text-gray-900 text-base mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot text-brand"></i>
                        Localização Geográfica
                    </h3>
                    <dl class="space-y-3 text-sm">
                        <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                            <dt class="text-gray-500 text-xs font-semibold uppercase">País</dt>
                            <dd class="font-bold text-gray-900">{{ $property->country }}</dd>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                            <dt class="text-gray-500 text-xs font-semibold uppercase">Cidade</dt>
                            <dd class="font-bold text-gray-900">{{ $property->city }}</dd>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                            <dt class="text-gray-500 text-xs font-semibold uppercase">Endereço / Zona</dt>
                            <dd class="font-bold text-gray-900 text-right">{{ $property->location ?: '—' }}</dd>
                        </div>
                        @if($property->latitude && $property->longitude)
                        <div class="pt-2">
                            <p class="text-xs text-gray-400 font-mono mb-2">GPS: {{ $property->latitude }}, {{ $property->longitude }}</p>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $property->latitude }},{{ $property->longitude }}"
                               target="_blank"
                               class="w-full py-2 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-sm text-xs font-bold text-brand flex items-center justify-center gap-1.5 transition">
                                <i class="fa-solid fa-diamond-turn-right"></i>
                                Abrir no Google Maps
                            </a>
                        </div>
                        @endif
                    </dl>
                </div>

                {{-- Interactive Media (Video / 3D) --}}
                @if($property->video_url || $property->tour_3d_url)
                <div class="bg-white rounded-sm border border-admin-border p-6 shadow-sm print-card no-print">
                    <h3 class="font-bold text-gray-900 text-base mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-photo-film text-brand"></i>
                        Media Interativa
                    </h3>
                    <div class="space-y-3">
                        @if($property->video_url)
                        <a href="{{ $property->video_url }}" target="_blank"
                           class="w-full p-3 bg-red-50 hover:bg-red-100 border border-red-200 rounded-sm text-xs font-bold text-red-600 flex items-center justify-between transition">
                            <span class="flex items-center gap-2">
                                <i class="fa-brands fa-youtube text-base text-red-500"></i>
                                Vídeo do Imóvel
                            </span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                        </a>
                        @endif

                        @if($property->tour_3d_url)
                        <a href="{{ $property->tour_3d_url }}" target="_blank"
                           class="w-full p-3 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-sm text-xs font-bold text-indigo-700 flex items-center justify-between transition">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-vr-cardboard text-base text-indigo-600"></i>
                                Visita Virtual 3D
                            </span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Gallery Grid --}}
        @if(count($allImages) > 0)
        <div class="bg-white rounded-sm border border-admin-border p-6 shadow-sm print-card">
            <h3 class="font-bold text-gray-900 text-base mb-4 flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-images text-brand"></i>
                    Galeria Fotográfica Completa
                </span>
                <span class="text-xs font-normal text-gray-500 font-mono">{{ count($allImages) }} foto(s)</span>
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @foreach($allImages as $gSrc)
                <button type="button" @click="selectedImg = '{{ $gSrc }}'; window.scrollTo({ top: 0, behavior: 'smooth' })"
                        class="group relative h-28 rounded-sm overflow-hidden bg-gray-100 border border-gray-200 hover:border-brand transition shadow-2xs">
                    <img src="{{ $gSrc }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fa-solid fa-eye text-white text-xs"></i>
                    </div>
                </button>
                @endforeach
            </div>
        </div>
        @endif

    </div>

</x-admin.layout>
