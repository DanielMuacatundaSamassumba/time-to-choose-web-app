<x-admin.layout title="Conteúdo das Páginas" breadcrumb="Gestão de conteúdo e imagens do site">

    <x-slot name="styles">
    <style>
        .page-card {
            position: relative;
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .page-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,107,0,0.05) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.35s;
        }
        .page-card:hover::before { opacity: 1; }
        .page-card:hover {
            border-color: #F97316;
            box-shadow: 0 12px 35px rgba(255,107,0,0.14), 0 2px 8px rgba(0,0,0,0.04);
            transform: translateY(-3px);
        }
        .thumb-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.2) 60%, rgba(0,0,0,0.1) 100%);
        }
        .section-pill {
            backdrop-filter: blur(4px);
        }
    </style>
    </x-slot>

    {{-- ── Header ───────────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
            <h2 class="text-xl font-bold text-admin-text">Páginas do Site</h2>
            <p class="text-sm text-admin-muted mt-1">
                Edite textos e imagens de cada página diretamente aqui — as alterações ficam visíveis imediatamente.
            </p>
        </div>
        <div class="flex items-center gap-2.5 bg-white border border-admin-border rounded-sm px-4 py-2.5 text-sm shadow-sm">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse inline-block"></span>
            <span class="text-admin-text font-semibold">{{ count($pages) }} páginas ativas</span>
        </div>
    </div>

    {{-- ── Pages Grid ──────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($pages as $pageKey => $page)
        <div onclick="window.location.href='{{ route('admin.content.edit', $pageKey) }}'"
             class="page-card group bg-white border border-admin-border rounded-sm flex flex-col overflow-hidden cursor-pointer select-none">

            {{-- Thumbnail --}}
            <div class="relative h-48 overflow-hidden bg-gray-100 flex-shrink-0">
                <img src="{{ asset('assets/' . ($page['thumb'] ?? 'Logo_Time.png')) }}"
                     alt="{{ $page['label'] }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="thumb-overlay absolute inset-0"></div>

                {{-- Badge do URL --}}
                <div class="absolute top-3 left-3">
                    <span class="text-[10px] font-mono font-medium bg-black/60 text-white px-2.5 py-1 rounded-full backdrop-blur-md shadow-sm border border-white/10">
                        {{ $page['url'] }}
                    </span>
                </div>

                {{-- Preview button --}}
                <button type="button"
                        onclick="event.stopPropagation(); window.open('{{ $page['url'] }}', '_blank')"
                        title="Pré-visualizar no site"
                        class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/20 backdrop-blur-md hover:bg-white/40 flex items-center justify-center transition shadow-sm">
                    <i class="fa-solid fa-arrow-up-right-from-square text-white text-xs"></i>
                </button>

                {{-- Page title overlay --}}
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-sm bg-brand flex items-center justify-center flex-shrink-0 shadow-md">
                            <i class="fa-solid {{ $page['icon'] }} text-white text-base"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-base leading-tight">{{ $page['label'] }}</h3>
                            <p class="text-white/80 text-[11px] font-medium">
                                {{ count($page['sections']) }} secções de texto •
                                {{ count($page['images'] ?? []) }} de imagem
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-5 flex flex-col gap-4 flex-1">

                {{-- Section pills --}}
                <div class="flex flex-wrap gap-1.5">
                    @foreach($page['sections'] as $section)
                    <span class="section-pill text-[10px] font-semibold bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full border border-gray-200/60">
                        {{ $section }}
                    </span>
                    @endforeach
                    @foreach(($page['images'] ?? []) as $imgSection)
                    <span class="section-pill text-[10px] font-semibold bg-brand/10 text-brand px-2.5 py-1 rounded-full border border-brand/20 flex items-center gap-1">
                        <i class="fa-solid fa-image text-[9px]"></i> {{ $imgSection }}
                    </span>
                    @endforeach
                </div>

                {{-- Footer action --}}
                <div class="mt-auto flex items-center justify-between pt-4 border-t border-admin-border">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-brand"></span>
                        <span class="text-xs font-medium text-admin-muted">
                            {{ count($page['sections']) + count($page['images'] ?? []) }} campos editáveis
                        </span>
                    </div>
                    <span class="flex items-center gap-1.5 bg-brand text-white text-xs font-bold px-4 py-2 rounded-sm group-hover:bg-brand-dark transition-colors duration-200 shadow-sm">
                        Editar
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-0.5 transition-transform duration-200"></i>
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Info Banner ─────────────────────────────────────────────── --}}
    <div class="mt-8 bg-amber-500/5 border border-amber-500/20 rounded-sm px-6 py-4 flex items-start gap-4">
        <div class="w-9 h-9 rounded-sm bg-amber-500/10 flex items-center justify-center flex-shrink-0 mt-0.5">
            <i class="fa-solid fa-lightbulb text-amber-600 text-sm"></i>
        </div>
        <div>
            <p class="text-sm font-bold text-admin-text mb-1">Como funciona a edição de conteúdo?</p>
            <p class="text-xs text-admin-muted leading-relaxed">
                Ao clicar em <strong>Editar</strong> em qualquer página, pode alterar os textos ou carregar novas imagens para cada secção.
                As etiquetas com <span class="inline-flex items-center gap-1 bg-brand/10 text-brand px-1.5 py-0.5 rounded text-[10px] font-semibold"><i class="fa-solid fa-image text-[9px]"></i> ícone de imagem</span>
                indicam secções onde é possível substituir imagens por ficheiros locais. As alterações são aplicadas instantaneamente no site.
            </p>
        </div>
    </div>

</x-admin.layout>
