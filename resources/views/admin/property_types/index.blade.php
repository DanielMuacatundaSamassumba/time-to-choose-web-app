<x-admin.layout title="Tipos & Classificações" breadcrumb="Gestão de Categorias e Terrenos">

    <div class="space-y-6" x-data="{
        tab: 'property_types',
        showCreateTypeModal: false,
        showEditTypeModal: false,
        editTypeId: null,
        editTypeName: '',
        editTypeSlug: '',
        editTypeNature: 'residential',
        editTypeUrl: '',

        showCreateLandModal: false,
        showEditLandModal: false,
        editLandId: null,
        editLandName: '',
        editLandSlug: '',
        editLandDescription: '',
        editLandUrl: '',

        openEditType(id, name, slug, nature, url) {
            this.editTypeId = id;
            this.editTypeName = name;
            this.editTypeSlug = slug;
            this.editTypeNature = nature || 'residential';
            this.editTypeUrl = url;
            this.showEditTypeModal = true;
        },

        openEditLand(id, name, slug, description, url) {
            this.editLandId = id;
            this.editLandName = name;
            this.editLandSlug = slug;
            this.editLandDescription = description || '';
            this.editLandUrl = url;
            this.showEditLandModal = true;
        }
    }">

        {{-- Top Stats & Action --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white rounded-sm border border-admin-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-sm bg-orange-50 text-[#F97316] flex items-center justify-center">
                        <i class="fa-solid fa-shapes text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-admin-muted">Tipos de Imóvel</p>
                        <p class="text-xl font-bold text-admin-text">{{ $stats['total_types'] }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-sm border border-admin-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-sm bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="fa-solid fa-mountain-sun text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-admin-muted">Classificações Terreno</p>
                        <p class="text-xl font-bold text-admin-text">{{ $stats['total_land_types'] }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-sm border border-admin-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-sm bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="fa-solid fa-circle-check text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-admin-muted">Tipos Activos</p>
                        <p class="text-xl font-bold text-admin-text">{{ $stats['active_types'] }}</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <template x-if="tab === 'property_types'">
                    <button @click="showCreateTypeModal = true"
                            class="bg-brand hover:bg-brand-dark text-white font-semibold text-sm px-5 py-3 rounded-sm flex items-center gap-2 shadow-sm transition">
                        <i class="fa-solid fa-plus"></i>
                        Novo Tipo de Imóvel
                    </button>
                </template>
                <template x-if="tab === 'land_types'">
                    <button @click="showCreateLandModal = true"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm px-5 py-3 rounded-sm flex items-center gap-2 shadow-sm transition">
                        <i class="fa-solid fa-plus"></i>
                        Nova Classificação
                    </button>
                </template>
            </div>
        </div>

        {{-- Navigation Tabs --}}
        <div class="flex border-b border-gray-200">
            <button @click="tab = 'property_types'"
                    :class="tab === 'property_types' ? 'border-[#F97316] text-[#F97316] font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 font-medium'"
                    class="py-3 px-6 text-sm border-b-2 transition flex items-center gap-2">
                <i class="fa-solid fa-house"></i>
                Tipos de Imóvel ({{ $types->count() }})
            </button>
            <button @click="tab = 'land_types'"
                    :class="tab === 'land_types' ? 'border-[#F97316] text-[#F97316] font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 font-medium'"
                    class="py-3 px-6 text-sm border-b-2 transition flex items-center gap-2">
                <i class="fa-solid fa-mountain-sun"></i>
                Classificações de Terrenos ({{ $landTypes->count() }})
            </button>
        </div>

        {{-- Feedback Messages --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-sm flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-red-500"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- TAB 1: Tipos de Imóveis --}}
        <div x-show="tab === 'property_types'" class="bg-white rounded-sm border border-admin-border overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Lista de Tipos de Imóvel</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Tipos disponíveis no formulário de cadastro e nos filtros de pesquisa do site.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-admin-muted text-xs uppercase font-semibold border-b border-admin-border">
                            <th class="px-6 py-4">Nome do Tipo</th>
                            <th class="px-4 py-4">Identificador (Slug)</th>
                            <th class="px-4 py-4">Natureza / Tipologia</th>
                            <th class="px-4 py-4">Imóveis Associados</th>
                            <th class="px-6 py-4 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($types as $type)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-sm bg-orange-100/80 text-[#F97316] flex items-center justify-center font-bold text-sm">
                                        <i class="fa-solid fa-house text-xs"></i>
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $type->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <code class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-sm text-xs font-mono">{{ $type->slug }}</code>
                            </td>
                            <td class="px-4 py-4">
                                @if($type->nature === 'area_based')
                                    <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full bg-purple-50 text-purple-700 font-medium">
                                        <i class="fa-solid fa-ruler-combined text-[10px]"></i> Baseado em Área (m² / ha)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 font-medium">
                                        <i class="fa-solid fa-bed text-[10px]"></i> Residencial (Quartos)
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-gray-500 text-xs">
                                <span class="font-bold text-gray-800">{{ $type->properties_count }}</span> imóveis
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="openEditType('{{ $type->id }}', '{{ addslashes($type->name) }}', '{{ $type->slug }}', '{{ $type->nature }}', '{{ route('admin.property-types.update', $type) }}')"
                                            class="p-2 text-gray-400 hover:text-brand hover:bg-brand/10 rounded-sm transition" title="Editar">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>

                                    <form action="{{ route('admin.property-types.destroy', $type) }}" method="POST"
                                          onsubmit="return confirm('Tem a certeza que deseja eliminar o tipo {{ $type->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-sm transition" title="Eliminar">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400">
                                Nenhum tipo de imóvel cadastrado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TAB 2: Classificações de Terrenos --}}
        <div x-show="tab === 'land_types'" class="bg-white rounded-sm border border-admin-border overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
                        <i class="fa-solid fa-mountain-sun text-emerald-600"></i>
                        Classificações de Terrenos
                    </h3>
                    <p class="text-xs text-gray-400 mt-0.5">Categorias para classificar terrenos (Urbanos, Rústicos, Industriais, Projectos Aprovados) e respetivos filtros de pesquisa.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-admin-muted text-xs uppercase font-semibold border-b border-admin-border">
                            <th class="px-6 py-4">Classificação</th>
                            <th class="px-4 py-4">Identificador (Slug)</th>
                            <th class="px-4 py-4">Descrição</th>
                            <th class="px-4 py-4">Terrenos Associados</th>
                            <th class="px-6 py-4 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($landTypes as $lt)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-sm bg-emerald-100/80 text-emerald-700 flex items-center justify-center font-bold text-sm">
                                        <i class="fa-solid fa-mountain-sun text-xs"></i>
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $lt->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <code class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-sm text-xs font-mono">{{ $lt->slug }}</code>
                            </td>
                            <td class="px-4 py-4 text-gray-500 text-xs max-w-xs truncate">
                                {{ $lt->description ?: '—' }}
                            </td>
                            <td class="px-4 py-4 text-gray-500 text-xs">
                                <span class="font-bold text-emerald-700">{{ $lt->properties_count }}</span> terrenos
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="openEditLand('{{ $lt->id }}', '{{ addslashes($lt->name) }}', '{{ $lt->slug }}', '{{ addslashes($lt->description) }}', '{{ route('admin.land-types.update', $lt) }}')"
                                            class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-sm transition" title="Editar">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>

                                    <form action="{{ route('admin.land-types.destroy', $lt) }}" method="POST"
                                          onsubmit="return confirm('Tem a certeza que deseja eliminar a classificação {{ $lt->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-sm transition" title="Eliminar">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400">
                                Nenhuma classificação de terreno cadastrada.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MODAL: Criar Tipo de Imóvel --}}
        <div x-show="showCreateTypeModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div @click.away="showCreateTypeModal = false" class="bg-white rounded-sm max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-gray-900 text-lg">Adicionar Tipo de Imóvel</h3>
                    <button @click="showCreateTypeModal = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('admin.property-types.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Nome do Tipo <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required placeholder="Ex: Quintas, Moradias, Pavilhões..."
                               class="w-full border border-gray-200 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Slug / Identificador (Opcional)</label>
                        <input type="text" name="slug" placeholder="Ex: quintas, moradias (gerado auto se vazio)"
                               class="w-full border border-gray-200 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand lowercase">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Natureza do Imóvel <span class="text-red-500">*</span></label>
                        <select name="nature" required class="w-full border border-gray-200 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                            <option value="residential">Residencial (Exibe Quartos / Tipologia T1, V3...)</option>
                            <option value="area_based">Comercial / Terreno (Baseado em Área m²)</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3">
                        <button type="button" @click="showCreateTypeModal = false"
                                class="px-4 py-2.5 rounded-sm border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-sm bg-brand hover:bg-brand-dark text-white text-sm font-semibold shadow transition">
                            Gravar Tipo
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: Editar Tipo de Imóvel --}}
        <div x-show="showEditTypeModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div @click.away="showEditTypeModal = false" class="bg-white rounded-sm max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-gray-900 text-lg">Editar Tipo de Imóvel</h3>
                    <button @click="showEditTypeModal = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form :action="editTypeUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Nome do Tipo <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="editTypeName" required
                               class="w-full border border-gray-200 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Slug / Identificador</label>
                        <input type="text" name="slug" x-model="editTypeSlug" required
                               class="w-full border border-gray-200 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand lowercase">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Natureza do Imóvel <span class="text-red-500">*</span></label>
                        <select name="nature" x-model="editTypeNature" required class="w-full border border-gray-200 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                            <option value="residential">Residencial (Exibe Quartos / Tipologia T1, V3...)</option>
                            <option value="area_based">Comercial / Terreno (Baseado em Área m²)</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3">
                        <button type="button" @click="showEditTypeModal = false"
                                class="px-4 py-2.5 rounded-sm border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-sm bg-brand hover:bg-brand-dark text-white text-sm font-semibold shadow transition">
                            Atualizar Tipo
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: Criar Classificação de Terreno --}}
        <div x-show="showCreateLandModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div @click.away="showCreateLandModal = false" class="bg-white rounded-sm max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                        <i class="fa-solid fa-mountain-sun text-emerald-600"></i>
                        Adicionar Classificação de Terreno
                    </h3>
                    <button @click="showCreateLandModal = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('admin.land-types.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Nome da Classificação <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required placeholder="Ex: Rústico, Urbano, Turístico..."
                               class="w-full border border-gray-200 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Slug / Identificador (Opcional)</label>
                        <input type="text" name="slug" placeholder="Ex: rusticos, urbanos (gerado auto se vazio)"
                               class="w-full border border-gray-200 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 lowercase">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Descrição (Opcional)</label>
                        <textarea name="description" rows="3" placeholder="Descrição breve sobre a finalidade deste tipo de terreno..."
                                  class="w-full border border-gray-200 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 resize-none"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3">
                        <button type="button" @click="showCreateLandModal = false"
                                class="px-4 py-2.5 rounded-sm border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-sm bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow transition">
                            Gravar Classificação
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: Editar Classificação de Terreno --}}
        <div x-show="showEditLandModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div @click.away="showEditLandModal = false" class="bg-white rounded-sm max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                        <i class="fa-solid fa-mountain-sun text-emerald-600"></i>
                        Editar Classificação de Terreno
                    </h3>
                    <button @click="showEditLandModal = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form :action="editLandUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Nome da Classificação <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="editLandName" required
                               class="w-full border border-gray-200 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Slug / Identificador</label>
                        <input type="text" name="slug" x-model="editLandSlug" required
                               class="w-full border border-gray-200 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 lowercase">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Descrição</label>
                        <textarea name="description" x-model="editLandDescription" rows="3"
                                  class="w-full border border-gray-200 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 resize-none"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3">
                        <button type="button" @click="showEditLandModal = false"
                                class="px-4 py-2.5 rounded-sm border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-sm bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow transition">
                            Atualizar Classificação
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</x-admin.layout>
