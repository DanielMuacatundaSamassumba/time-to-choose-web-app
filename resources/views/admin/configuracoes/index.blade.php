<x-admin.layout title="Configurações Globais" breadcrumb="Definições do Site">

    <div class="max-w-5xl">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- 1. Contactos Principais --}}
            <div class="bg-white rounded-2xl border border-admin-border p-6 mb-6">
                <h3 class="font-bold text-admin-text mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-address-book text-brand"></i>
                    Contactos Principais do Site
                </h3>

                @php
                    $g = $settings['global'] ?? [];
                    $labelClass = "block text-xs font-semibold text-admin-muted uppercase tracking-wider mb-2";
                    $inputClass = "w-full border border-gray-200 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition";
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="{{ $labelClass }}">Nome da Empresa</label>
                        <input type="text" name="company_name" value="{{ old('company_name', $g['company_name'] ?? 'Time To Choose') }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Telefone Principal</label>
                        <input type="text" name="phone" value="{{ old('phone', $g['phone'] ?? '+244 923 000 000') }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">E-mail de Contacto</label>
                        <input type="email" name="email" value="{{ old('email', $g['email'] ?? 'info@timetochoose.ao') }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Número / Link de WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $g['whatsapp'] ?? '+244 923 000 000') }}" class="{{ $inputClass }}" placeholder="Ex: +244923000000">
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="{{ $labelClass }}">Endereço Físico</label>
                        <input type="text" name="address" value="{{ old('address', $g['address'] ?? 'Talatona, Luanda, Angola') }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">URL do Website</label>
                        <input type="text" name="website_url" value="{{ old('website_url', $g['website_url'] ?? 'www.timetochoose.ao') }}" class="{{ $inputClass }}">
                    </div>
                </div>
            </div>

            {{-- 2. Redes Sociais --}}
            <div class="bg-white rounded-2xl border border-admin-border p-6 mb-6">
                <h3 class="font-bold text-admin-text mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-share-nodes text-brand"></i>
                    Redes Sociais
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="{{ $labelClass }}"><i class="fab fa-facebook text-blue-600 mr-1"></i> Facebook URL</label>
                        <input type="text" name="facebook" value="{{ old('facebook', $g['facebook'] ?? '#') }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}"><i class="fab fa-instagram text-pink-600 mr-1"></i> Instagram URL</label>
                        <input type="text" name="instagram" value="{{ old('instagram', $g['instagram'] ?? '#') }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}"><i class="fab fa-linkedin text-blue-700 mr-1"></i> LinkedIn URL</label>
                        <input type="text" name="linkedin" value="{{ old('linkedin', $g['linkedin'] ?? '#') }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}"><i class="fab fa-youtube text-red-600 mr-1"></i> YouTube URL</label>
                        <input type="text" name="youtube" value="{{ old('youtube', $g['youtube'] ?? '#') }}" class="{{ $inputClass }}">
                    </div>
                </div>
            </div>

            {{-- 3. Logótipo & SEO Padrão --}}
            <div class="bg-white rounded-2xl border border-admin-border p-6 mb-6">
                <h3 class="font-bold text-admin-text mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-brand"></i>
                    Logótipo & SEO Padrão
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="col-span-1 md:col-span-2">
                        <label class="{{ $labelClass }}">Logótipo do Site</label>
                        @if(!empty($g['logo']))
                            <div class="mb-3 flex items-center gap-3">
                                <span class="text-xs text-admin-muted">Atual:</span>
                                <img src="{{ Storage::url($g['logo']) }}" class="h-10 p-2 bg-slate-900 rounded-lg border">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-admin-muted file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-brand/10 file:text-brand file:text-sm file:font-medium hover:file:bg-brand/20 transition">
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="{{ $labelClass }}">Descrição Padrão para SEO (Meta Description)</label>
                        <textarea name="default_seo_desc" rows="3" class="{{ $inputClass }}">{{ old('default_seo_desc', $g['default_seo_desc'] ?? 'Time To Choose - Mediação, gestão e consultoria imobiliária em Luanda, Angola.') }}</textarea>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="{{ $labelClass }}">Palavras-chave Padrão para SEO (Meta Keywords)</label>
                        <input type="text" name="default_seo_keys" value="{{ old('default_seo_keys', $g['default_seo_keys'] ?? 'imóveis, luanda, angola, arrendamento, venda, imobiliária') }}" class="{{ $inputClass }}">
                    </div>
                </div>
            </div>

            {{-- Save Button --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-brand hover:bg-brand-dark text-white font-semibold px-8 py-3 rounded-xl transition flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Guardar Configurações
                </button>
            </div>

        </form>
    </div>

</x-admin.layout>
