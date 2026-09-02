{{--
    Partial: Section Card
    Props:
      $title   — Section display title
      $icon    — FontAwesome icon class
      $section — DB section key
      $fields  — array of field definitions
        Each: ['key' => '...', 'label' => '...', 'type' => 'text|textarea|image', 'hint' => '...']
--}}
<div class="section-card bg-white border border-admin-border rounded-sm mb-5 overflow-hidden">

    {{-- Card Header --}}
    <div class="flex items-center gap-3 px-6 py-4 border-b border-admin-border bg-gray-50/50">
        <div class="w-8 h-8 rounded-sm bg-brand/10 flex items-center justify-center flex-shrink-0">
            <i class="fa-solid {{ $icon }} text-brand text-sm"></i>
        </div>
        <h3 class="font-bold text-admin-text text-sm">{{ $title }}</h3>
        <span class="ml-auto text-[10px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full font-mono">{{ $section }}</span>
    </div>

    {{-- Fields --}}
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
        @foreach($fields as $field)
        @php
            $inputName  = $section . '__' . $field['key'];
            $currentVal = $sections[$section][$field['key']] ?? '';
            $fieldType  = $field['type'] ?? 'text';
            $hint       = $field['hint'] ?? null;
            $isImage    = ($fieldType === 'image');
            $isTextarea = ($fieldType === 'textarea');
            $colSpan    = ($isTextarea || $isImage) ? 'md:col-span-2' : '';
        @endphp

        <div class="{{ $colSpan }}">
            <label for="field_{{ $section }}_{{ $field['key'] }}" class="field-label block mb-1.5">
                @if($isImage)
                    <span class="inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-image text-brand text-[10px]"></i>
                        {{ $field['label'] }}
                    </span>
                @else
                    {{ $field['label'] }}
                @endif
            </label>

            @if($isImage)
                {{-- ── Image Upload Field ──────────────────────────────── --}}
                @php
                    $imgInputName = 'img__' . $section . '__' . $field['key'];
                    // Resolve current image URL
                    if ($currentVal) {
                        // If stored in public storage (starts with page-images/ or properties/)
                        $imgUrl = str_starts_with($currentVal, 'page-images/')
                            ? \Illuminate\Support\Facades\Storage::url($currentVal)
                            : asset('assets/' . $currentVal);
                    } else {
                        $imgUrl = null;
                    }
                    $previewId = 'preview_' . $section . '_' . $field['key'];
                @endphp
                <div class="border border-dashed border-gray-200 rounded-sm overflow-hidden bg-gray-50/50 hover:border-brand/50 transition-colors duration-200"
                     x-data="{ dragging: false }"
                     @dragover.prevent="dragging = true"
                     @dragleave="dragging = false"
                     @drop.prevent="dragging = false">

                    {{-- Preview --}}
                    <div class="relative" id="{{ $previewId }}_wrap">
                        @if($imgUrl)
                        <img id="{{ $previewId }}"
                             src="{{ $imgUrl }}"
                             alt="Imagem atual"
                             class="w-full h-52 object-cover">
                        <div class="absolute inset-0 bg-black/0 hover:bg-black/20 transition-colors flex items-center justify-center opacity-0 hover:opacity-100">
                            <span class="bg-white text-admin-text text-xs font-semibold px-3 py-1.5 rounded-full shadow">
                                Clique para substituir
                            </span>
                        </div>
                        @else
                        <div id="{{ $previewId }}" class="w-full h-44 flex flex-col items-center justify-center gap-3 text-admin-muted">
                            <div class="w-14 h-14 rounded-sm bg-gray-100 flex items-center justify-center">
                                <i class="fa-solid fa-image text-2xl text-gray-300"></i>
                            </div>
                            <p class="text-xs">Sem imagem definida</p>
                        </div>
                        @endif
                    </div>

                    {{-- Upload area --}}
                    <div class="p-4 border-t border-gray-100">
                        <label for="{{ $imgInputName }}_input"
                               class="flex items-center gap-3 cursor-pointer group/upload">
                            <div class="w-9 h-9 rounded-sm bg-brand/10 group-hover/upload:bg-brand flex items-center justify-center flex-shrink-0 transition-colors">
                                <i class="fa-solid fa-upload text-brand group-hover/upload:text-white text-sm transition-colors"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-admin-text group-hover/upload:text-brand transition-colors">
                                    Carregar nova imagem
                                </p>
                                <p class="text-[10px] text-admin-muted">JPG, PNG, WEBP — máx. 5MB</p>
                            </div>
                        </label>
                        <input type="file"
                               id="{{ $imgInputName }}_input"
                               name="{{ $imgInputName }}"
                               accept="image/*"
                               class="hidden"
                               onchange="previewImage(this, '{{ $previewId }}')">
                    </div>
                </div>
                @if($currentVal)
                <p class="field-hint mt-1.5 flex items-center gap-1">
                    <i class="fa-solid fa-circle-check text-green-400 text-[9px]"></i>
                    Imagem actual: <span class="text-gray-500">{{ basename($currentVal) }}</span>
                    &nbsp;— Deixe vazio para manter a imagem atual.
                </p>
                @endif

            @elseif($isTextarea)
                <textarea
                    id="field_{{ $section }}_{{ $field['key'] }}"
                    name="{{ $inputName }}"
                    class="w-full border border-gray-200 rounded-sm px-4 py-3 text-sm text-admin-text focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition"
                    rows="3">{{ $currentVal }}</textarea>
            @elseif($fieldType === 'select')
                <select
                    id="field_{{ $section }}_{{ $field['key'] }}"
                    name="{{ $inputName }}"
                    class="w-full border border-gray-200 rounded-sm px-4 py-3 text-sm text-admin-text focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition">
                    @foreach($field['options'] ?? [] as $optVal => $optLabel)
                        <option value="{{ $optVal }}" {{ (string)$currentVal === (string)$optVal ? 'selected' : '' }}>{{ $optLabel }}</option>
                    @endforeach
                </select>
            @elseif($fieldType === 'color')
                <div class="flex items-center gap-3">
                    <input
                        type="color"
                        id="field_{{ $section }}_{{ $field['key'] }}"
                        name="{{ $inputName }}"
                        value="{{ $currentVal ?: '#F97316' }}"
                        class="w-12 h-11 border border-gray-200 rounded-sm p-1 cursor-pointer bg-white">
                    <input
                        type="text"
                        value="{{ $currentVal ?: '#F97316' }}"
                        oninput="document.getElementById('field_{{ $section }}_{{ $field['key'] }}').value = this.value"
                        class="flex-1 border border-gray-200 rounded-sm px-4 py-2.5 text-sm font-mono text-admin-text focus:outline-none focus:border-brand">
                </div>
            @else
                <input
                    type="text"
                    id="field_{{ $section }}_{{ $field['key'] }}"
                    name="{{ $inputName }}"
                    value="{{ $currentVal }}"
                    class="w-full border border-gray-200 rounded-sm px-4 py-3 text-sm text-admin-text focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition">
            @endif

            @if($hint && !$isImage)
                <p class="field-hint">{{ $hint }}</p>
            @endif
        </div>
        @endforeach
    </div>
</div>
