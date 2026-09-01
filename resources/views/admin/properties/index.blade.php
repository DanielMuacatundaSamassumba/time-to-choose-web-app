<x-admin.layout title="Imóveis" breadcrumb="Gerir todas as propriedades">

    <!-- Filters & Actions bar -->
    <div class="bg-white rounded-2xl border border-admin-border p-5 mb-6">
        <form action="{{ route('admin.properties.index') }}" method="GET"
              class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[180px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Pesquisar por título ou localização..."
                       class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition">
            </div>

            {{-- Filtro unificado: igual ao menu e à página pública --}}
            <select name="filter_category"
                    class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition">
                <option value="">Tipo de Negócio</option>
                <option value="venda"                      {{ request('filter_category') === 'venda'                      ? 'selected' : '' }}>️ Venda</option>
                <option value="arrendamento-longa-duracao" {{ request('filter_category') === 'arrendamento-longa-duracao' ? 'selected' : '' }}> Arrendamento de Longa Duração</option>
                <option value="arrendamento-curta-duracao" {{ request('filter_category') === 'arrendamento-curta-duracao' ? 'selected' : '' }}>⚡ Arrendamento de Curta Duração</option>
                <option value="transpasse"                 {{ request('filter_category') === 'transpasse'                 ? 'selected' : '' }}> Transpasse</option>
            </select>

            <select name="property_type"
                    class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition">
                <option value="">Todos os Tipos de Imóvel</option>
                @foreach(\App\Models\Property::propertyTypes() as $val => $label)
                    <option value="{{ $val }}" {{ request('property_type') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            {{-- Classificação do Terreno --}}
            <select name="land_type"
                    class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition">
                <option value="">Classificação Terreno</option>
                <option value="urbanos" {{ request('land_type') === 'urbanos' ? 'selected' : '' }}>Urbanos</option>
                <option value="rusticos" {{ request('land_type') === 'rusticos' ? 'selected' : '' }}>Rústicos</option>
                <option value="industriais" {{ request('land_type') === 'industriais' ? 'selected' : '' }}>Industriais</option>
                <option value="projecto-aprovado" {{ request('land_type') === 'projecto-aprovado' ? 'selected' : '' }}>Projectos Aprovados</option>
            </select>

            {{-- País --}}
            <select name="country"
                    class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition">
                <option value="">Todos os Países</option>
                @foreach(\App\Models\Property::select('country')->distinct()->orderBy('country')->pluck('country') as $c)
                    <option value="{{ $c }}" {{ request('country') === $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>

            <select name="status"
                    class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition">
                <option value="">Todos os estados</option>
                <option value="disponivel" {{ request('status') === 'disponivel' ? 'selected' : '' }}>Disponível</option>
                <option value="reservado" {{ request('status') === 'reservado' ? 'selected' : '' }}>Reservado</option>
                <option value="arrendado" {{ request('status') === 'arrendado' ? 'selected' : '' }}>Arrendado</option>
                <option value="vendido" {{ request('status') === 'vendido' ? 'selected' : '' }}>Vendido</option>
            </select>

            <button type="submit"
                    class="bg-brand hover:bg-brand-dark text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition flex items-center gap-2">
                <i class="fa-solid fa-filter"></i>
                Filtrar
            </button>

            @if(request()->hasAny(['search', 'filter_category', 'property_type', 'land_type', 'country', 'status']))
            <a href="{{ route('admin.properties.index') }}" class="text-gray-400 hover:text-gray-600 text-sm px-3 py-2.5">
                <i class="fa-solid fa-xmark mr-1"></i>Limpar
            </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-admin-border overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5 border-b border-admin-border">
            <div>
                <h2 class="font-bold text-admin-text">Lista de Imóveis</h2>
                <p class="text-xs text-admin-muted mt-0.5">{{ $properties->total() }} imóveis encontrados</p>
            </div>
            <a href="{{ route('admin.properties.create') }}"
               class="bg-brand hover:bg-brand-dark text-white text-sm font-semibold px-4 py-2 rounded-xl flex items-center gap-2 transition">
                <i class="fa-solid fa-plus"></i>
                Novo Imóvel
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-admin-border">
                        <th class="text-left text-xs font-semibold text-admin-muted uppercase tracking-wider px-6 py-4">Imóvel</th>
                        <th class="text-left text-xs font-semibold text-admin-muted uppercase tracking-wider px-4 py-4">Tipo</th>
                        <th class="text-left text-xs font-semibold text-admin-muted uppercase tracking-wider px-4 py-4">Preço</th>
                        <th class="text-left text-xs font-semibold text-admin-muted uppercase tracking-wider px-4 py-4">Estado</th>
                        <th class="text-left text-xs font-semibold text-admin-muted uppercase tracking-wider px-4 py-4">Visibilidade</th>
                        <th class="text-left text-xs font-semibold text-admin-muted uppercase tracking-wider px-4 py-4">Destaque</th>
                        <th class="text-left text-xs font-semibold text-admin-muted uppercase tracking-wider px-4 py-4">Criado</th>
                        <th class="px-4 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border">
                    @forelse($properties as $property)
                    <tr class="hover:bg-gray-50 transition group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <a href="{{ route('admin.properties.show', $property) }}" class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100 block hover:opacity-90 transition">
                                    @if($property->image && file_exists(public_path('assets/' . $property->image)))
                                        <img src="{{ asset('assets/' . $property->image) }}" class="w-full h-full object-cover">
                                    @elseif($property->image && str_starts_with($property->image, 'properties/'))
                                        <img src="{{ Storage::url($property->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-brand/10 flex items-center justify-center">
                                            <i class="fa-solid fa-building text-brand"></i>
                                        </div>
                                    @endif
                                </a>
                                <div>
                                    <a href="{{ route('admin.properties.show', $property) }}"
                                       class="font-semibold text-sm text-admin-text hover:text-brand transition block">
                                        {{ $property->title }}
                                    </a>
                                    <p class="text-xs text-admin-muted mt-0.5">
                                        <i class="fa-solid fa-location-dot mr-1 text-brand/60"></i>{{ $property->location }}
                                    </p>
                                    <div class="flex items-center gap-3 mt-1 text-[11px] text-admin-muted">
                                        @if($property->bedrooms > 0)
                                        <span><i class="fa-solid fa-bed mr-1"></i>{{ $property->bedrooms }}</span>
                                        @endif
                                        @if($property->bathrooms > 0)
                                        <span><i class="fa-solid fa-shower mr-1"></i>{{ $property->bathrooms }}</span>
                                        @endif
                                        @if($property->area)
                                        <span><i class="fa-solid fa-ruler-combined mr-1"></i>{{ $property->area }}</span>
                                        @endif
                                        @if($property->owner_name || $property->owner_phone)
                                        <span title="Proprietário: {{ $property->owner_name }} ({{ $property->owner_phone }})"
                                              class="cursor-help text-amber-700 bg-amber-50 border border-amber-200 text-[10px] font-medium px-1.5 py-0.2 rounded flex items-center gap-1">
                                            <i class="fa-solid fa-user-shield text-[9px]"></i>
                                            {{ $property->owner_name ?: $property->owner_phone }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap"> 
                            @if($property->category === 'arrendamento-longa-duracao') 
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700"> 
                                    Longa Duração 
                                </span> 
                            @elseif($property->category === 'arrendamento-curta-duracao') 
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-50 text-amber-700"> 
                                    Curta Duração 
                                </span> 
                            @elseif($property->category === 'transpasse' || strtolower($property->type) === 'transpasse') 
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-purple-50 text-purple-700"> 
                                    Transpasse 
                                </span> 
                            @elseif(strtolower($property->type) === 'arrendamento') 
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700"> 
                                    Arrendamento 
                                </span> 
                            @else 
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-orange-50 text-orange-700"> 
                                    Venda 
                                </span> 
                            @endif 
     
                            <p class="text-[11px] text-admin-muted mt-1"> 
                                {{ $property->property_type_label }} 
                            </p>
                            @if($property->land_type)
                            <span class="inline-block text-[10px] font-medium px-1.5 py-0.5 mt-0.5 rounded bg-green-50 text-green-700 border border-green-200">
                                {{ $property->land_type_label ?? ucfirst($property->land_type) }}
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <p class="text-sm font-bold text-brand">{{ $property->price }}</p>
                            @if($property->price_period)
                            <p class="text-[11px] text-admin-muted">{{ $property->price_period }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $property->status_badge['class'] }}">
                                {{ $property->status_badge['label'] }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <form action="{{ route('admin.properties.toggle-active', $property) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        title="{{ $property->is_active ? 'Clique para ocultar do site' : 'Clique para tornar visível no site' }}"
                                        class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full transition {{ $property->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                    <i class="fa-solid {{ $property->is_active ? 'fa-circle-check text-emerald-500' : 'fa-eye-slash text-gray-400' }} text-[11px]"></i>
                                    <span>{{ $property->is_active ? 'Visível' : 'Oculto' }}</span>
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-4">
                            @if($property->is_featured)
                                <span class="text-yellow-500"><i class="fa-solid fa-star"></i></span>
                            @else
                                <span class="text-gray-200"><i class="fa-regular fa-star"></i></span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-xs text-admin-muted">
                            {{ $property->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                                <a href="{{ route('admin.properties.show', $property) }}"
                                   title="Ver Ficha Técnica" class="p-2 text-gray-400 hover:text-brand hover:bg-brand/10 rounded-lg transition">
                                    <i class="fa-solid fa-file-lines text-xs"></i>
                                </a>
                                <a href="{{ route('properties.show', $property) }}" target="_blank"
                                   title="Ver no site público" class="p-2 text-gray-400 hover:text-blue-500 hover:bg-blue-50 rounded-lg transition">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                </a>
                                <a href="{{ route('admin.properties.edit', $property) }}"
                                   title="Editar" class="p-2 text-gray-400 hover:text-brand hover:bg-brand/10 rounded-lg transition">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('admin.properties.destroy', $property) }}" method="POST"
                                      onsubmit="return confirm('Tem a certeza que deseja eliminar este imóvel?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Eliminar"
                                            class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-16 text-admin-muted">
                            <i class="fa-solid fa-building text-5xl mb-4 opacity-20 block"></i>
                            <p class="text-sm font-medium">Nenhum imóvel encontrado.</p>
                            <a href="{{ route('admin.properties.create') }}" class="text-brand text-sm hover:underline mt-2 inline-block">
                                Criar o primeiro imóvel →
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($properties->hasPages())
        <div class="px-6 py-4 border-t border-admin-border">
            {{ $properties->links() }}
        </div>
        @endif
    </div>

</x-admin.layout>
