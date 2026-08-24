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
                            ? $property->category          // arrendamento-longa/curta
                            : ($property?->type === 'venda' ? 'venda' : '')
                    );
                @endphp
                <option value="" disabled {{ $bc === '' ? 'selected' : '' }}>— Selecionar —</option>
                <option value="venda"                      {{ $bc === 'venda'                      ? 'selected' : '' }}>
                    Venda
                </option>
                <option value="arrendamento-longa-duracao" {{ $bc === 'arrendamento-longa-duracao' ? 'selected' : '' }}>
                     Arrendamento de Longa Duração
                </option>
                <option value="arrendamento-curta-duracao" {{ $bc === 'arrendamento-curta-duracao' ? 'selected' : '' }}>
                 Arrendamento de Curta Duração
                </option>
                <option value="transpasse" {{ $bc === 'transpasse' ? 'selected' : '' }}>
               Transpasse
                </option>
            </select>
        </div>
        <div>
            <label class="{{ $labelClass }}">Tipo de Imóvel <span class="text-red-400">*</span></label>
            <select name="property_type" class="{{ $inputClass }}" required>
                @foreach(['apartamento','vivenda','Espaços Comercias', "terreno"] as $pt)
                <option value="{{ $pt }}" {{ old('property_type', $property?->property_type) === $pt ? 'selected' : '' }}>
                    {{ ucfirst($pt) }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="{{ $labelClass }}">Preço</label>
            <input type="text" name="price" value="{{ old('price', $property?->price) }}"
                   placeholder="Ex: 350.000 Kz"
                   class="{{ $inputClass }}">
        </div>
        <div>
            <label class="{{ $labelClass }}">Período</label>
            <input type="text" name="price_period" value="{{ old('price_period', $property?->price_period) }}"
                   placeholder="Ex: / mês"
                   class="{{ $inputClass }}">
        </div>
        <div class="col-span-2">
            <label class="{{ $labelClass }}">Localização (Zona/Bairro)</label>
            <input type="text" name="location" value="{{ old('location', $property?->location) }}"
                   placeholder="Ex: Talatona, Ingombota, Miramar..."
                   class="{{ $inputClass }}">
        </div>

        {{-- País e Cidade --}}
        <div>
            <label class="{{ $labelClass }}">País <span class="text-red-400">*</span></label>
            <select name="country" class="{{ $inputClass }}" required>
                @foreach(['Angola','Portugal','África do Sul','Estados Unidos','Brasil','França','Espanha','Outro'] as $c)
                <option value="{{ $c }}" {{ old('country', $property?->country ?? 'Angola') === $c ? 'selected' : '' }}>
                    {{ $c }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="{{ $labelClass }}">Cidade <span class="text-red-400">*</span></label>
            <input type="text" name="city" value="{{ old('city', $property?->city ?? 'Luanda') }}"
                   placeholder="Ex: Luanda, Lisboa, Pretória..."
                   class="{{ $inputClass }}" required>
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
</div>

<!-- Details -->
<div class="bg-white rounded-2xl border border-admin-border p-6">
    <h3 class="font-bold text-admin-text mb-5 flex items-center gap-2">
        <i class="fa-solid fa-list-check text-brand"></i>
        Detalhes
    </h3>
    <div class="grid grid-cols-3 gap-5 mb-5">
        <div>
            <label class="{{ $labelClass }}"><i class="fa-solid fa-bed mr-1 text-brand/60"></i>Quartos</label>
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
                   {{ old('is_featured', $property?->is_featured) ? 'checked' : '' }}>
            <div>
                <p class="text-sm font-semibold text-admin-text">Em Destaque</p>
                <p class="text-xs text-admin-muted">Aparece na homepage</p>
            </div>
            <i class="fa-solid fa-star text-yellow-400 ml-auto"></i>
        </label>
        <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-brand transition">
            <input type="checkbox" name="is_active" value="1" class="accent-brand w-4 h-4"
                   {{ old('is_active', $property?->is_active ?? true) ? 'checked' : '' }}>
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
        @if($isEdit && $property->gallery)
        <div class="flex flex-wrap gap-2 mb-3">
            @foreach($property->gallery as $img)
            <div class="w-20 h-16 rounded-lg overflow-hidden bg-gray-100">
                @if(str_starts_with($img, 'properties/'))
                    <img src="{{ Storage::url($img) }}" class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('assets/' . $img) }}" class="w-full h-full object-cover">
                @endif
            </div>
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
                       if (!galleryError && totalMB > 80) {
                           galleryError = 'Total da galeria (' + totalMB.toFixed(1) + ' MB) excede 80 MB. Seleciona menos imagens.';
                           $event.target.value = '';
                       }
                   ">
            <p class="text-xs text-gray-400 mt-1">Máx. 50 MB por imagem — total até 80 MB</p>
            <p x-show="galleryError" x-text="galleryError" class="text-xs text-red-500 mt-1 font-semibold"></p>
        </div>
    </div>
</div>

@push('scripts')
<script>
function propertyForm() {
    return {}
}
</script>
@endpush
