<x-admin.layout title="Países e Cidades" breadcrumb="Gestão de Localizações">

    <div class="space-y-6" x-data="{
        showCountryModal: false,
        showCityModal: false,
        selectedCountryId: '',
        selectedCountryName: '',
        openCityModal(countryId, countryName) {
            this.selectedCountryId = countryId;
            this.selectedCountryName = countryName;
            this.showCityModal = true;
        }
    }">

        {{-- Top Stats & Action --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-2xl border border-admin-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-[#F97316] flex items-center justify-center">
                        <i class="fa-solid fa-earth-africa text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-admin-muted">Total de Países</p>
                        <p class="text-xl font-bold text-admin-text">{{ $stats['total_countries'] }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-admin-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="fa-solid fa-city text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-admin-muted">Total de Cidades</p>
                        <p class="text-xl font-bold text-admin-text">{{ $stats['total_cities'] }}</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button @click="showCountryModal = true"
                        class="bg-brand hover:bg-brand-dark text-white font-semibold text-sm px-5 py-3 rounded-xl flex items-center gap-2 shadow-sm transition">
                    <i class="fa-solid fa-plus"></i>
                    Adicionar País
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

        {{-- Countries & Cities Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($countries as $country)
            <div class="bg-white rounded-2xl border border-admin-border overflow-hidden shadow-sm flex flex-col justify-between">
                {{-- Header --}}
                <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-orange-100/80 text-[#F97316] font-bold text-xs flex items-center justify-center">
                            {{ $country->code ?: substr($country->name, 0, 2) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base leading-tight">{{ $country->name }}</h3>
                            <span class="text-xs text-gray-400">{{ $country->cities_count }} {{ $country->cities_count == 1 ? 'cidade' : 'cidades' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-1">
                        <button @click="openCityModal('{{ $country->id }}', '{{ $country->name }}')"
                                title="Adicionar cidade a {{ $country->name }}"
                                class="p-2 text-[#F97316] hover:bg-orange-50 rounded-lg transition">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </button>
                        <form action="{{ route('admin.locations.countries.destroy', $country) }}" method="POST"
                              onsubmit="return confirm('Tem a certeza que deseja remover {{ $country->name }} e todas as suas cidades?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Remover País"
                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Cities List --}}
                <div class="p-5 flex-1">
                    @if($country->cities->isEmpty())
                        <div class="py-6 text-center text-gray-400 text-xs">
                            <p>Nenhuma cidade cadastrada ainda.</p>
                            <button @click="openCityModal('{{ $country->id }}', '{{ $country->name }}')"
                                    class="mt-2 text-brand font-semibold hover:underline">
                                + Adicionar primeira cidade
                            </button>
                        </div>
                    @else
                        <div class="flex flex-wrap gap-2">
                            @foreach($country->cities as $city)
                            <div class="group inline-flex items-center gap-1.5 bg-gray-100 hover:bg-orange-50 border border-gray-200 hover:border-orange-200 text-gray-700 hover:text-orange-900 text-xs px-3 py-1.5 rounded-full transition">
                                <span>{{ $city->name }}</span>
                                <form action="{{ route('admin.locations.cities.destroy', $city) }}" method="POST"
                                      onsubmit="return confirm('Remover cidade {{ $city->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 opacity-60 group-hover:opacity-100 transition" title="Remover cidade">
                                        <i class="fa-solid fa-xmark text-[10px]"></i>
                                    </button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Footer Button --}}
                <div class="p-4 bg-gray-50 border-t border-gray-100">
                    <button @click="openCityModal('{{ $country->id }}', '{{ $country->name }}')"
                            class="w-full text-center text-xs font-semibold text-brand hover:text-brand-dark py-1 flex items-center justify-center gap-1.5 transition">
                        <i class="fa-solid fa-circle-plus"></i>
                        Adicionar Cidade a {{ $country->name }}
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-admin-border text-gray-400">
                <i class="fa-solid fa-earth-africa text-4xl mb-3 text-gray-300"></i>
                <p>Nenhum país cadastrado de momento.</p>
            </div>
            @endforelse
        </div>

        {{-- MODAL: Adicionar País --}}
        <div x-show="showCountryModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div @click.away="showCountryModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-gray-900 text-lg">Adicionar Novo País</h3>
                    <button @click="showCountryModal = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('admin.locations.countries.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Nome do País <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required placeholder="Ex: Namíbia, Emirados Árabes Unidos..."
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Código (Sigla ISO)</label>
                        <input type="text" name="code" placeholder="Ex: AO, PT, NA, AE" maxlength="10"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand uppercase">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3">
                        <button type="button" @click="showCountryModal = false"
                                class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-brand hover:bg-brand-dark text-white text-sm font-semibold shadow transition">
                            Gravar País
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: Adicionar Cidade --}}
        <div x-show="showCityModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div @click.away="showCityModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-gray-900 text-lg">
                        Adicionar Cidade a <span class="text-[#F97316]" x-text="selectedCountryName"></span>
                    </h3>
                    <button @click="showCityModal = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('admin.locations.cities.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="country_id" :value="selectedCountryId">

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Nome da Cidade <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required placeholder="Ex: Benguela, Lubango, Porto..."
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3">
                        <button type="button" @click="showCityModal = false"
                                class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-brand hover:bg-brand-dark text-white text-sm font-semibold shadow transition">
                            Gravar Cidade
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</x-admin.layout>
