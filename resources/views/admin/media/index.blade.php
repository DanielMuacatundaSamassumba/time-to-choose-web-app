<x-admin.layout title="Biblioteca de Media" breadcrumb="Imagens & Ficheiros">

    <!-- Search & Info Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <form action="{{ route('admin.media.index') }}" method="GET" class="flex items-center gap-3 flex-1 max-w-md">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Pesquisar por nome de ficheiro ou pasta..."
                       class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition">
            </div>
            <button type="submit" class="bg-brand hover:bg-brand-dark text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
                Filtrar
            </button>
        </form>

        <div class="text-sm text-admin-muted">
            Total: <span class="font-bold text-admin-text">{{ count($files) }}</span> ficheiros de imagem
        </div>
    </div>

    <!-- Media Grid -->
    @if(count($files) > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($files as $file)
        <div class="bg-white rounded-2xl border border-admin-border overflow-hidden group hover:border-brand/50 transition duration-200 flex flex-col justify-between"
             x-data="{ copied: false }">

            <div class="relative aspect-square bg-gray-100 overflow-hidden">
                <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                <span class="absolute top-2 left-2 text-[10px] font-bold bg-black/60 text-white px-2 py-0.5 rounded-md backdrop-blur">
                    {{ strtoupper(pathinfo($file['name'], PATHINFO_EXTENSION)) }}
                </span>
            </div>

            <div class="p-3 flex-1 flex flex-col justify-between">
                <div>
                    <p class="text-xs font-semibold text-admin-text truncate" title="{{ $file['name'] }}">{{ $file['name'] }}</p>
                    <p class="text-[11px] text-admin-muted mt-0.5 flex items-center justify-between">
                        <span>{{ $file['size_formatted'] }}</span>
                        <span class="bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded text-[9px] font-mono">{{ $file['folder'] }}</span>
                    </p>
                </div>

                <div class="flex items-center gap-1 mt-3 pt-2 border-t border-gray-100">
                    <button type="button"
                            @click="navigator.clipboard.writeText('{{ $file['url'] }}'); copied = true; setTimeout(() => copied = false, 2000)"
                            class="flex-1 text-[11px] font-medium py-1.5 px-2 rounded-lg border border-gray-200 text-gray-600 hover:border-brand hover:text-brand transition flex items-center justify-center gap-1">
                        <i class="fa-regular" :class="copied ? 'fa-circle-check text-green-600' : 'fa-copy'"></i>
                        <span x-text="copied ? 'Copiado!' : 'Copiar URL'"></span>
                    </button>

                    <form action="{{ route('admin.media.destroy') }}" method="POST"
                          onsubmit="return confirm('Tem a certeza que deseja eliminar esta imagem do disco?')">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="path" value="{{ $file['path'] }}">
                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition" title="Eliminar imagem">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-2xl border border-admin-border p-12 text-center text-admin-muted">
        <i class="fa-regular fa-image text-4xl text-gray-300 mb-3"></i>
        <p class="font-semibold text-admin-text">Nenhuma imagem encontrada</p>
        <p class="text-xs text-admin-muted mt-1">As imagens enviadas nos imóveis e nas páginas do CMS aparecerão aqui automaticamente.</p>
    </div>
    @endif

</x-admin.layout>
