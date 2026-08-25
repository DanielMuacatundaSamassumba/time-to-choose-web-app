<x-admin.layout title="Tipos de Imóveis" breadcrumb="Gestão de Categorias">

    <div class="space-y-6" x-data="{
        showCreateModal: false,
        showEditModal: false,
        editId: null,
        editName: '',
        editSlug: '',
        editNature: 'residential',
        editUrl: '',
        openEdit(id, name, slug, nature, url) {
            this.editId = id;
            this.editName = name;
            this.editSlug = slug;
            this.editNature = nature || 'residential';
            this.editUrl = url;
            this.showEditModal = true;
        }
    }">

        {{-- Top Stats & Action --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-2xl border border-admin-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-[#F97316] flex items-center justify-center">
                        <i class="fa-solid fa-shapes text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-admin-muted">Total de Tipos</p>
                        <p class="text-xl font-bold text-admin-text">{{ $stats['total_types'] }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-admin-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="fa-solid fa-circle-check text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-admin-muted">Tipos Activos</p>
                        <p class="text-xl font-bold text-admin-text">{{ $stats['active_types'] }}</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button @click="showCreateModal = true"
                        class="bg-brand hover:bg-brand-dark text-white font-semibold text-sm px-5 py-3 rounded-xl flex items-center gap-2 shadow-sm transition">
                    <i class="fa-solid fa-plus"></i>
                    Adicionar Novo Tipo
                </button>
            </div>
        </div>

        {{-- Feedback Messages --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-red-500"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-white rounded-2xl border border-admin-border overflow-hidden shadow-sm">
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
                                    <div class="w-9 h-9 rounded-xl bg-orange-100/80 text-[#F97316] flex items-center justify-center font-bold text-sm">
                                        <i class="fa-solid fa-house text-xs"></i>
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $type->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <code class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-md text-xs font-mono">{{ $type->slug }}</code>
                            </td>
                            <td class="px-4 py-4">
                                @if($type->nature === 'area_based')
                                    <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full bg-purple-50 text-purple-700 font-medium">
                                        <i class="fa-solid fa-ruler-combined text-[10px]"></i> Baseado em Área (m²)
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
                                    <button @click="openEdit('{{ $type->id }}', '{{ addslashes($type->name) }}', '{{ $type->slug }}', '{{ $type->nature }}', '{{ route('admin.property-types.update', $type) }}')"
                                            class="p-2 text-gray-400 hover:text-brand hover:bg-brand/10 rounded-lg transition" title="Editar">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>

                                    <form action="{{ route('admin.property-types.destroy', $type) }}" method="POST"
                                          onsubmit="return confirm('Tem a certeza que deseja eliminar o tipo {{ $type->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Eliminar">
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

        {{-- MODAL: Criar Tipo --}}
        <div x-show="showCreateModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div @click.away="showCreateModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-gray-900 text-lg">Adicionar Tipo de Imóvel</h3>
                    <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('admin.property-types.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Nome do Tipo <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required placeholder="Ex: Quintas, Moradias, Pavilhões..."
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Slug / Identificador (Opcional)</label>
                        <input type="text" name="slug" placeholder="Ex: quintas, moradias (gerado auto se vazio)"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand lowercase">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Natureza do Imóvel <span class="text-red-500">*</span></label>
                        <select name="nature" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                            <option value="residential">Residencial (Exibe Quartos / Tipologia T1, V3...)</option>
                            <option value="area_based">Comercial / Terreno (Baseado em Área m²)</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3">
                        <button type="button" @click="showCreateModal = false"
                                class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-brand hover:bg-brand-dark text-white text-sm font-semibold shadow transition">
                            Gravar Tipo
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: Editar Tipo --}}
        <div x-show="showEditModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div @click.away="showEditModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-gray-900 text-lg">Editar Tipo de Imóvel</h3>
                    <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form :action="editUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Nome do Tipo <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="editName" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Slug / Identificador</label>
                        <input type="text" name="slug" x-model="editSlug" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand lowercase">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Natureza do Imóvel <span class="text-red-500">*</span></label>
                        <select name="nature" x-model="editNature" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                            <option value="residential">Residencial (Exibe Quartos / Tipologia T1, V3...)</option>
                            <option value="area_based">Comercial / Terreno (Baseado em Área m²)</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3">
                        <button type="button" @click="showEditModal = false"
                                class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-brand hover:bg-brand-dark text-white text-sm font-semibold shadow transition">
                            Atualizar Tipo
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</x-admin.layout>
