@php
    $isEdit = isset($property) && $property !== null;
    $inputClass = 'w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition';
    $labelClass = 'block text-sm font-semibold text-admin-text mb-1.5';
    $errorClass = 'text-red-500 text-xs mt-1';
@endphp

@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl flex items-start gap-3 mb-4">
    <i class="fa-solid fa-triangle-exclamation mt-0.5"></i>
    <ul class="text-sm space-y-1">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Basic Info -->
<div class="bg-white rounded-2xl border border-admin-border p-6">
    <h3 class="font-bold text-admin-text mb-5 flex items-center gap-2">
        <i class="fa-solid fa-info-circle text-brand"></i>
        Informações Básicas
    </h3>
    <div class="grid grid-cols-1 gap-5">
        <!-- Title -->
        <div>
            <label class="{{ $labelClass }}">Título do Imóvel <span class="text-red-400">*</span></label>
            <input type="text" name="title" value="{{ old('title', $property?->title) }}"
                   placeholder="Ex: Apartamento Premium T3 — Talatona"
                   class="{{ $inputClass }} {{ $errors->has('title') ? 'border-red-300' : '' }}" required>
            @error('title') <p class="{{ $errorClass }}">{{ $message }}</p> @enderror
        </div>
        <!-- Description -->
        <div>
            <label class="{{ $labelClass }}">Descrição</label>
            <textarea name="description" rows="4"
                      placeholder="Descreva o imóvel com detalhe..."
                      class="{{ $inputClass }} resize-none">{{ old('description', $property?->description) }}</textarea>
        </div>
    </div>
</div>

<!-- Pricing & Classification -->
<div class="bg-white rounded-2xl border border-admin-border p-6">
    <h3 class="font-bold text-admin-text mb-5 flex items-center gap-2">
        <i class="fa-solid fa-tags text-brand"></i>
        Classificação e Preço
    </h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
        {{-- TIPO DE NEGÓCIO UNIFICADO (igual ao menu e à página de imóveis) --}}
        <div class="col-span-2 md:col-span-1">
            <label class="{{ $labelClass }}">Tipo de Negócio <span class="text-red-400">*</span></label>
            <select name="business_category" class="{{ $inputClass }}" required>
                @php
                    $bc = old('business_category',
                        $property?->category
                            ? $property->category          // arrendamento-longa/curta, transpasse
                            : ($property?->type === 'venda' ? 'venda' : ($property?->type ? strtolower($property->type) : ''))
                    );
                @endphp
                <option value="" disabled {{ $bc === '' ? 'selected' : '' }}>— Selecionar —</option>
                <option value="venda" {{ $bc === 'venda' ? 'selected' : '' }}>
                    Venda
                </option>
                <optgroup label="Arrendamento">
                    <option value="arrendamento-longa-duracao" {{ $bc === 'arrendamento-longa-duracao' ? 'selected' : '' }}>
                        Arrendamento de Longa Duração
                    </option>
                    <option value="arrendamento-curta-duracao" {{ $bc === 'arrendamento-curta-duracao' ? 'selected' : '' }}>
                        Arrendamento de Curta Duração
                    </option>
                </optgroup>
                <option value="transpasse" {{ $bc === 'transpasse' ? 'selected' : '' }}>
                    Transpasse
                </option>
            </select>
            <p class="text-[11px] text-gray-500 mt-1">Selecione se é Venda, Longa Duração, Curta Duração ou Transpasse.</p>
        </div>
        <div>
            <label class="{{ $labelClass }}">Tipo de Imóvel <span class="text-red-400">*</span></label>
            <select name="property_type" id="form_property_type" class="{{ $inputClass }}" required>
                <option value="" disabled {{ empty($property?->property_type) ? 'selected' : '' }}>— Selecionar —</option>
                @php
                    $currentPt = strtolower(trim((string) old('property_type', $property?->property_type ?? '')));
                @endphp
                @foreach(\App\Models\Property::propertyTypes() as $key => $label)
                    <option value="{{ $key }}" {{ ($currentPt === $key || ($key === 'espaco-comercial' && str_contains($currentPt, 'comercia')) || ($key === 'escritorio' && str_contains($currentPt, 'escrit')) || ($key === 'terreno' && str_contains($currentPt, 'terren'))) ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        {{-- Valor do Preço e Moeda Separados --}}
        @php
            $rawPrice = $property?->price ?? '';
            $extractedCurrency = 'Kz';
            $extractedAmount = $rawPrice;

            if (stripos($rawPrice, 'sob consulta') !== false) {
                $extractedCurrency = 'Sob Consulta';
                $extractedAmount = '';
            } elseif (preg_match('/(usd|\$)/i', $rawPrice)) {
                $extractedCurrency = 'USD';
                $extractedAmount = trim(preg_replace('/(usd|\$)/i', '', $rawPrice));
            } elseif (preg_match('/(eur|euros|€)/i', $rawPrice)) {
                $extractedCurrency = 'EUR';
                $extractedAmount = trim(preg_replace('/(eur|euros|€)/i', '', $rawPrice));
            } elseif (preg_match('/(kz|aoa|kwanzas)/i', $rawPrice)) {
                $extractedCurrency = 'Kz';
                $extractedAmount = trim(preg_replace('/(kz|aoa|kwanzas)/i', '', $rawPrice));
            }

            $currentCurrency = old('price_currency', $extractedCurrency);
            $currentAmount = old('price_amount', $extractedAmount);
            $currentPeriod = old('price_period', $property?->price_period ?? '');
        @endphp

        <div>
            <label class="{{ $labelClass }}">Valor</label>
            <input type="text" name="price_amount" id="price_amount" value="{{ $currentAmount }}"
                   placeholder="Ex: 3.750.000"
                   oninput="formatPriceInput(this)"
                   class="{{ $inputClass }}">
        </div>

        <div>
            <label class="{{ $labelClass }}">Moeda</label>
            <select name="price_currency" class="{{ $inputClass }}">
                <option value="Kz" {{ $currentCurrency === 'Kz' ? 'selected' : '' }}>Kz (AOA - Kwanzas)</option>
                <option value="USD" {{ $currentCurrency === 'USD' ? 'selected' : '' }}>USD ($ - Dólares)</option>
                <option value="EUR" {{ $currentCurrency === 'EUR' ? 'selected' : '' }}>EUR (€ - Euros)</option>
                <option value="Sob Consulta" {{ $currentCurrency === 'Sob Consulta' ? 'selected' : '' }}>Sob Consulta</option>
            </select>
        </div>

        <div>
            <label class="{{ $labelClass }}">Período de Arrendamento</label>
            <select name="price_period" class="{{ $inputClass }}">
                <option value="" {{ empty($currentPeriod) ? 'selected' : '' }}>— Não aplicável (Venda/Total) —</option>
                <option value="/ mês" {{ in_array($currentPeriod, ['/ mês', '/ mes', 'mês', 'mes']) ? 'selected' : '' }}>/ Mês</option>
                <option value="/ dia" {{ in_array($currentPeriod, ['/ dia', 'dia']) ? 'selected' : '' }}>/ Dia</option>
                <option value="/ ano" {{ in_array($currentPeriod, ['/ ano', 'ano']) ? 'selected' : '' }}>/ Ano</option>
                <option value="/ semana" {{ in_array($currentPeriod, ['/ semana', 'semana']) ? 'selected' : '' }}>/ Semana</option>
            </select>
        </div>
        <div class="col-span-2">
            <label class="{{ $labelClass }}">Localização (Zona/Bairro)</label>
            <input type="text" name="location" value="{{ old('location', $property?->location) }}"
                   placeholder="Ex: Talatona, Ingombota, Miramar..."
                   class="{{ $inputClass }}">
        </div>

        {{-- País e Cidade Dependentes --}}
        @php
            $cityMap = \App\Models\Country::getCityMap();
            $currentCountry = old('country', $property?->country ?? 'Angola');
            $currentCity = old('city', $property?->city ?? 'Luanda');
        @endphp
        <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-5"
             x-data="{
                 cityMap: {{ json_encode($cityMap) }},
                 selectedCountry: '{{ $currentCountry }}',
                 selectedCity: '{{ $currentCity }}',
                 customCity: false,
                 get availableCities() {
                     return this.selectedCountry ? (this.cityMap[this.selectedCountry] ?? []) : [];
                 },
                 onCountryChange() {
                     const cities = this.availableCities;
                     if (cities.length > 0) {
                         if (!cities.includes(this.selectedCity)) {
                             this.selectedCity = cities[0];
                         }
                         this.customCity = false;
                     } else {
                         this.selectedCity = '';
                         this.customCity = true;
                     }
                 }
             }">
            <div>
                <label class="{{ $labelClass }}">País <span class="text-red-400">*</span></label>
                <select name="country" x-model="selectedCountry" @change="onCountryChange()" class="{{ $inputClass }}" required>
                    <option value="" disabled>— Selecione o País —</option>
                    @foreach(array_keys($cityMap) as $c)
                    <option value="{{ $c }}">{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="{{ $labelClass }} !mb-0">Cidade <span class="text-red-400">*</span></label>
                    <button type="button" @click="customCity = !customCity" class="text-[11px] text-brand hover:underline">
                        <span x-show="!customCity">+ Digitar outra</span>
                        <span x-show="customCity">← Escolher da lista</span>
                    </button>
                </div>

                {{-- Select de Cidades vinculadas ao país --}}
                <div x-show="!customCity && availableCities.length > 0">
                    <select name="city" x-model="selectedCity" :disabled="customCity" class="{{ $inputClass }}" required>
                        <template x-for="cityName in availableCities" :key="cityName">
                            <option :value="cityName" :selected="selectedCity === cityName" x-text="cityName"></option>
                        </template>
                    </select>
                </div>

                {{-- Input texto quando não há cidades ou para cidade personalizada --}}
                <div x-show="customCity || availableCities.length === 0" x-cloak>
                    <input type="text" name="city" x-model="selectedCity" :disabled="!customCity && availableCities.length > 0"
                           placeholder="Digite o nome da cidade..."
                           class="{{ $inputClass }}" required>
                </div>
            </div>
        </div>

        <div>
            <label class="{{ $labelClass }}">Estado <span class="text-red-400">*</span></label>
            <select name="status" class="{{ $inputClass }}" required>
                <option value="disponivel" {{ old('status', $property?->status) === 'disponivel' ? 'selected' : '' }}>Disponível</option>
                <option value="reservado"  {{ old('status', $property?->status) === 'reservado' ? 'selected' : '' }}>Reservado</option>
                <option value="arrendado"  {{ old('status', $property?->status) === 'arrendado' ? 'selected' : '' }}>Arrendado</option>
                <option value="vendido"    {{ old('status', $property?->status) === 'vendido' ? 'selected' : '' }}>Vendido</option>
            </select>
        </div>
        <div>
            <label class="{{ $labelClass }}">Área</label>
            <input type="text" name="area" value="{{ old('area', $property?->area) }}"
                   placeholder="Ex: 145 m²"
                   class="{{ $inputClass }}">
        </div>
    </div>

    {{-- Classificação do Terreno (Exibido quando Tipo de Imóvel = Terrenos) --}}
    <div x-data="{ pt: '{{ old('property_type', $property?->property_type ?? '') }}' }"
         x-init="() => {
             const el = document.getElementById('form_property_type');
             if (el) {
                 pt = el.value;
                 el.addEventListener('change', e => pt = e.target.value);
             }
         }"
         x-show="pt.includes('terren')"
         x-cloak
         class="mt-5 bg-orange-50/70 border border-orange-200 rounded-2xl p-5 transition">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-gray-900 mb-1 flex items-center gap-2">
                    <i class="fa-solid fa-mountain-sun text-brand"></i>
                    Classificação do Terreno
                </label>
                <p class="text-xs text-gray-500">Defina se o terreno é Urbano, Rústico, Industrial ou com Projecto Aprovado para correta filtragem no site.</p>
            </div>
            <div>
                <select name="land_type" class="{{ $inputClass }}">
                    <option value="">— Selecionar Classificação —</option>
                    @php
                        $currentLandType = old('land_type', $property?->land_type ?? '');
                    @endphp
                    @foreach(\App\Models\Property::landTypes() as $lKey => $lLabel)
                        <option value="{{ $lKey }}" @selected($currentLandType === $lKey)>{{ $lLabel }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Details -->
<div class="bg-white rounded-2xl border border-admin-border p-6">
    <h3 class="font-bold text-admin-text mb-5 flex items-center gap-2">
        <i class="fa-solid fa-list-check text-brand"></i>
        Detalhes
    </h3>
    <div class="grid grid-cols-3 gap-5 mb-5">
        <div x-data="{
            pt: '{{ old('property_type', $property?->property_type ?? '') }}',
            get label() {
                if (this.pt.includes('vivend')) return 'Quartos (Tipologia V: V1, V2...)';
                if (this.pt.includes('apart') || this.pt.includes('moradia') || this.pt === 'casa') return 'Quartos (Tipologia T: T1, T2...)';
                return 'Quartos (N/A para não residencial)';
            }
        }"
        x-init="() => {
            const el = document.getElementById('form_property_type');
            if (el) {
                pt = el.value;
                el.addEventListener('change', e => pt = e.target.value);
            }
        }">
            <label class="{{ $labelClass }}">
                <i class="fa-solid fa-bed mr-1 text-brand/60"></i>
                <span x-text="label">Quartos</span>
            </label>
            <input type="number" name="bedrooms" min="0" value="{{ old('bedrooms', $property?->bedrooms ?? 0) }}"
                   class="{{ $inputClass }}">
        </div>
        <div>
            <label class="{{ $labelClass }}"><i class="fa-solid fa-shower mr-1 text-brand/60"></i>Casas de Banho</label>
            <input type="number" name="bathrooms" min="0" value="{{ old('bathrooms', $property?->bathrooms ?? 0) }}"
                   class="{{ $inputClass }}">
        </div>
        <div>
            <label class="{{ $labelClass }}"><i class="fa-solid fa-car mr-1 text-brand/60"></i>Garagens</label>
            <input type="number" name="garages" min="0" value="{{ old('garages', $property?->garages ?? 0) }}"
                   class="{{ $inputClass }}">
        </div>
    </div>
    <div>
        <label class="{{ $labelClass }}">Comodidades <span class="text-gray-400 font-normal">(separadas por vírgula)</span></label>
        <input type="text" name="amenities"
               value="{{ old('amenities', $isEdit ? implode(', ', $property->amenities ?? []) : '') }}"
               placeholder="Ex: Piscina, Segurança 24h, Ginásio, Ar Condicionado"
               class="{{ $inputClass }}">
    </div>
    <!-- Toggles -->
    <div class="grid grid-cols-2 gap-4 mt-5">
        <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-brand transition">
            <input type="checkbox" name="is_featured" value="1" class="accent-brand w-4 h-4"
                   {{ old('is_featured', $property?->is_featured ?? false) ? 'checked' : '' }}>
            <div>
                <p class="text-sm font-semibold text-admin-text">Em Destaque</p>
                <p class="text-xs text-admin-muted">Aparece na homepage</p>
            </div>
            <i class="fa-solid fa-star text-yellow-400 ml-auto"></i>
        </label>
        <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-brand transition">
            <input type="checkbox" name="is_active" value="1" class="accent-brand w-4 h-4"
                   {{ old('is_active', $property ? (bool)$property->is_active : true) ? 'checked' : '' }}>
            <div>
                <p class="text-sm font-semibold text-admin-text">Activo</p>
                <p class="text-xs text-admin-muted">Visível no site público</p>
            </div>
            <i class="fa-solid fa-circle-check text-green-400 ml-auto"></i>
        </label>
    </div>
</div>

<!-- Media & Advanced Location -->
<div class="bg-white rounded-2xl border border-admin-border p-6">
    <h3 class="font-bold text-admin-text mb-5 flex items-center gap-2">
        <i class="fa-solid fa-map-location-dot text-brand"></i>
        Media e Localização Avançada
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="{{ $labelClass }}">Link do Vídeo (YouTube, MP4 ou Vimeo)</label>
            <input type="text" name="video_url" value="{{ old('video_url', $property?->video_url) }}"
                   placeholder="Ex: https://www.youtube.com/watch?v=..."
                   class="{{ $inputClass }}">
        </div>
        <div>
            <label class="{{ $labelClass }}">Link da Visita 3D (Matterport, Tour Virtual)</label>
            <input type="text" name="tour_3d_url" value="{{ old('tour_3d_url', $property?->tour_3d_url) }}"
                   placeholder="Ex: https://my.matterport.com/show/?m=..."
                   class="{{ $inputClass }}">
        </div>
        <div>
            <label class="{{ $labelClass }}">Latitude (Opcional)</label>
            <input type="text" name="latitude" value="{{ old('latitude', $property?->latitude) }}"
                   placeholder="Ex: -8.8149"
                   class="{{ $inputClass }}">
        </div>
        <div>
            <label class="{{ $labelClass }}">Longitude (Opcional)</label>
            <input type="text" name="longitude" value="{{ old('longitude', $property?->longitude) }}"
                   placeholder="Ex: 13.2306"
                   class="{{ $inputClass }}">
        </div>
    </div>
</div>

<!-- Dados do Proprietário (Confidencial / Uso Interno) -->
<div class="bg-white rounded-2xl border border-admin-border p-6">
    <div class="flex items-center justify-between mb-2">
        <h3 class="font-bold text-admin-text flex items-center gap-2">
            <i class="fa-solid fa-user-shield text-brand"></i>
            Dados do Proprietário
            <span class="text-xs font-normal text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-0.5 rounded-full flex items-center gap-1">
                <i class="fa-solid fa-lock text-[10px]"></i>Uso Interno / Confidencial
            </span>
        </h3>
    </div>
    <p class="text-xs text-admin-muted mb-5">Estas informações de contacto são estritamente para gestão interna e <strong>não são visíveis ao público</strong> em nenhuma página do site.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <div class="col-span-1 md:col-span-2 lg:col-span-1">
            <label class="{{ $labelClass }}">Nome do Proprietário</label>
            <input type="text" name="owner_name" value="{{ old('owner_name', $property?->owner_name) }}"
                   placeholder="Ex: Manuel António, Imobiliária XPTO"
                   class="{{ $inputClass }}">
        </div>

        <div>
            <label class="{{ $labelClass }}">Telefone</label>
            <input type="text" name="owner_phone" value="{{ old('owner_phone', $property?->owner_phone) }}"
                   placeholder="Ex: +244 923 000 000"
                   class="{{ $inputClass }}">
        </div>

        <div>
            <label class="{{ $labelClass }}">WhatsApp</label>
            <input type="text" name="owner_whatsapp" value="{{ old('owner_whatsapp', $property?->owner_whatsapp) }}"
                   placeholder="Ex: +244 923 000 000"
                   class="{{ $inputClass }}">
        </div>

        <div>
            <label class="{{ $labelClass }}">E-mail</label>
            <input type="email" name="owner_email" value="{{ old('owner_email', $property?->owner_email) }}"
                   placeholder="Ex: proprietario@email.com"
                   class="{{ $inputClass }}">
        </div>

        <div class="col-span-1 md:col-span-2 lg:col-span-2">
            <label class="{{ $labelClass }}">Website / Link</label>
            <input type="text" name="owner_website" value="{{ old('owner_website', $property?->owner_website) }}"
                   placeholder="Ex: https://www.proprietario.com"
                   class="{{ $inputClass }}">
        </div>
    </div>
</div>

<!-- Images -->
<div class="bg-white rounded-2xl border border-admin-border p-6">
    <h3 class="font-bold text-admin-text mb-5 flex items-center gap-2">
        <i class="fa-solid fa-images text-brand"></i>
        Imagens
    </h3>
    <!-- Main image -->
    <div class="mb-6">
        <label class="{{ $labelClass }}">Imagem Principal</label>
        @if($isEdit && $property->image)
        <div class="mb-3">
            <p class="text-xs text-admin-muted mb-2">Imagem actual:</p>
            @if(file_exists(public_path('assets/' . $property->image)))
                <img src="{{ asset('assets/' . $property->image) }}" class="w-32 h-24 object-cover rounded-xl border">
            @elseif(str_starts_with($property->image, 'properties/'))
                <img src="{{ Storage::url($property->image) }}" class="w-32 h-24 object-cover rounded-xl border">
            @endif
        </div>
        @endif
        <div x-data="{ preview: null, sizeError: '' }"
             class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-brand transition cursor-pointer"
             @click="$refs.imgInput.click()">
            <template x-if="!preview && !sizeError">
                <div>
                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-300 mb-2"></i>
                    <p class="text-sm text-admin-muted">Clique para selecionar ou arraste uma imagem</p>
                    <p class="text-xs text-gray-300 mt-1">PNG, JPG, WEBP — máx. 50 MB por ficheiro</p>
                </div>
            </template>
            <template x-if="sizeError">
                <div>
                    <i class="fa-solid fa-triangle-exclamation text-3xl text-red-400 mb-2"></i>
                    <p class="text-sm text-red-500 font-semibold" x-text="sizeError"></p>
                </div>
            </template>
            <template x-if="preview && !sizeError">
                <img :src="preview" class="w-full max-h-48 object-cover rounded-xl">
            </template>
            <input type="file" name="image" accept="image/*" x-ref="imgInput" class="hidden"
                   @change="
                       const f = $event.target.files[0];
                       if (f && f.size > 50 * 1024 * 1024) {
                           sizeError = 'Ficheiro demasiado grande: ' + (f.size/1024/1024).toFixed(1) + ' MB. Máximo: 50 MB.';
                           preview = null;
                           $event.target.value = '';
                       } else {
                           sizeError = '';
                           preview = f ? URL.createObjectURL(f) : null;
                       }
                   ">
        </div>
    </div>
    <!-- Gallery -->
    <div>
        <label class="{{ $labelClass }}">Galeria <span class="text-gray-400 font-normal">(múltiplas imagens)</span></label>
        @if($isEdit && $property->gallery && count($property->gallery))
        <p class="text-xs text-admin-muted mb-2">Imagens actuais — marca o ícone para remover ao guardar:</p>
        <div class="flex flex-wrap gap-3 mb-4">
            @foreach($property->gallery as $img)
            <label class="relative w-20 h-16 rounded-lg overflow-hidden bg-gray-100 block cursor-pointer group">
                @if(str_starts_with($img, 'properties/'))
                    <img src="{{ Storage::url($img) }}" class="w-full h-full object-cover peer-checked:opacity-40">
                @else
                    <img src="{{ asset('assets/' . $img) }}" class="w-full h-full object-cover">
                @endif
                <input type="checkbox" name="remove_gallery[]" value="{{ $img }}"
                       class="peer absolute opacity-0 w-0 h-0">
                <span class="absolute top-1 right-1 w-5 h-5 rounded-full bg-white/90 text-gray-500 flex items-center justify-center text-[10px] shadow peer-checked:bg-red-500 peer-checked:text-white transition"
                      title="Remover imagem">
                    <i class="fa-solid fa-trash"></i>
                </span>
                <span class="absolute inset-0 bg-red-500/30 opacity-0 peer-checked:opacity-100 transition pointer-events-none"></span>
            </label>
            @endforeach
        </div>
        @endif
        <div x-data="{ galleryError: '' }">
            <input type="file" name="gallery[]" accept="image/*" multiple
                   class="block w-full text-sm text-admin-muted file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-brand/10 file:text-brand file:text-sm file:font-medium hover:file:bg-brand/20 transition"
                   @change="
                       galleryError = '';
                       let totalMB = 0;
                       for (const f of $event.target.files) {
                           if (f.size > 50 * 1024 * 1024) {
                               galleryError = f.name + ' excede 50 MB. Por favor reduz o tamanho.';
                               $event.target.value = ''; break;
                           }
                           totalMB += f.size / 1024 / 1024;
                       }
                       if (!galleryError && totalMB > 100) {
                           galleryError = 'Total da galeria (' + totalMB.toFixed(1) + ' MB) excede 100 MB. Seleciona menos imagens.';
                           $event.target.value = '';
                       }
                   ">
            <p class="text-xs text-gray-400 mt-1">
                @if($isEdit) As novas imagens são <strong>adicionadas</strong> às existentes. @endif
                Máx. 50 MB por imagem — até 60 imagens, total 100 MB.
            </p>
            <p x-show="galleryError" x-text="galleryError" class="text-xs text-red-500 mt-1 font-semibold"></p>
        </div>
    </div>
</div>

@push('scripts')
<script>
function formatPriceInput(input) {
    let clean = input.value.replace(/\D/g, '');
    if (!clean) {
        input.value = '';
        return;
    }
    input.value = new Intl.NumberFormat('de-DE').format(clean);
}

function propertyForm() {
    return {}
}
</script>
@endpush
