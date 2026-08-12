<x-admin.layout :title="'Editar — ' . $pageLabel" :breadcrumb="'Conteúdo / ' . $pageLabel">

    <x-slot name="styles">
    <style>
        .section-card { transition: box-shadow 0.2s; }
        .section-card:hover { box-shadow: 0 4px 20px rgba(255,107,0,0.08); }
        textarea { resize: vertical; min-height: 90px; }
        .field-label { font-size: 0.75rem; font-weight: 600; color: #6B6B6B; text-transform: uppercase; letter-spacing: 0.05em; }
        .field-hint  { font-size: 0.7rem; color: #9ca3af; margin-top: 2px; }
        .img-drop-active { border-color: #F97316 !important; background: rgba(255,107,0,0.04); }
    </style>
    </x-slot>

    {{-- Back + Preview --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.content.index') }}"
           class="flex items-center gap-2 text-sm text-admin-muted hover:text-admin-text transition">
            <i class="fa-solid fa-arrow-left text-xs"></i> Todas as páginas
        </a>
        <span class="text-admin-border">|</span>
        @php
            $previewUrls = [
                'home'       => '/',
                'imoveis'    => '/imoveis',
                'about'      => '/sobre-nos',
                'investors'  => '/investidores',
                'valuation'  => '/avaliacao-de-imoveis',
                'management' => '/gestao-de-propriedades',
                'partners'   => '/propriedades-e-parceiros',
            ];
        @endphp
        <a href="{{ $previewUrls[$page] ?? '/' }}" target="_blank"
           class="flex items-center gap-1.5 text-sm text-brand hover:underline">
            <i class="fa-solid fa-eye text-xs"></i> Pré-visualizar página
        </a>
    </div>

    <form action="{{ route('admin.content.update', $page) }}" method="POST" id="contentForm"
          enctype="multipart/form-data">
        @csrf

        {{-- ═══════════════════════════════════════════════════════
             HOMEPAGE
        ═══════════════════════════════════════════════════════ --}}
        @if($page === 'home')

            @include('admin.content.partials.section-card', [
                'title'   => 'Hero',
                'icon'    => 'fa-image',
                'section' => 'hero',
                'fields'  => [
                    ['key' => 'title',    'label' => 'Título Principal', 'type' => 'textarea', 'hint' => 'Use <br/> para quebra de linha'],
                    ['key' => 'subtitle', 'label' => 'Subtítulo',        'type' => 'text'],
                    ['key' => 'image',    'label' => 'Imagem de Fundo / Banner', 'type' => 'image'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'Tipos de Propriedades (Cabeçalho)',
                'icon'    => 'fa-layer-group',
                'section' => 'categories',
                'fields'  => [
                    ['key' => 'tag',   'label' => 'Etiqueta', 'type' => 'text'],
                    ['key' => 'title', 'label' => 'Título',   'type' => 'text'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'Imóveis em Destaque (Cabeçalho)',
                'icon'    => 'fa-star',
                'section' => 'featured',
                'fields'  => [
                    ['key' => 'tag',         'label' => 'Etiqueta',       'type' => 'text'],
                    ['key' => 'title',       'label' => 'Título',         'type' => 'text'],
                    ['key' => 'button_text', 'label' => 'Texto do Botão', 'type' => 'text'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'O Que Nós Fazemos (Serviços)',
                'icon'    => 'fa-briefcase',
                'section' => 'services',
                'fields'  => [
                    ['key' => 'tag',         'label' => 'Etiqueta',          'type' => 'text'],
                    ['key' => 'title',       'label' => 'Título da Secção',  'type' => 'text'],
                    ['key' => 'srv_1_title', 'label' => 'Serviço 1 — Título', 'type' => 'text'],
                    ['key' => 'srv_1_desc',  'label' => 'Serviço 1 — Texto',  'type' => 'textarea'],
                    ['key' => 'srv_2_title', 'label' => 'Serviço 2 — Título', 'type' => 'text'],
                    ['key' => 'srv_2_desc',  'label' => 'Serviço 2 — Texto',  'type' => 'textarea'],
                    ['key' => 'srv_3_title', 'label' => 'Serviço 3 — Título', 'type' => 'text'],
                    ['key' => 'srv_3_desc',  'label' => 'Serviço 3 — Texto',  'type' => 'textarea'],
                    ['key' => 'srv_4_title', 'label' => 'Serviço 4 — Título', 'type' => 'text'],
                    ['key' => 'srv_4_desc',  'label' => 'Serviço 4 — Texto',  'type' => 'textarea'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'Imóveis Internacionais em Destaque',
                'icon'    => 'fa-globe',
                'section' => 'international',
                'fields'  => [
                    ['key' => 'tag',         'label' => 'Etiqueta',       'type' => 'text'],
                    ['key' => 'title',       'label' => 'Título',         'type' => 'text'],
                    ['key' => 'button_text', 'label' => 'Texto do Botão', 'type' => 'text'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'CTA Banner Final',
                'icon'    => 'fa-bullhorn',
                'section' => 'cta',
                'fields'  => [
                    ['key' => 'title',       'label' => 'Título Principal', 'type' => 'textarea'],
                    ['key' => 'subtitle',    'label' => 'Subtítulo',        'type' => 'textarea'],
                    ['key' => 'button_text', 'label' => 'Texto do Botão',   'type' => 'text'],
                ],
            ])

        @endif

        {{-- ═══════════════════════════════════════════════════════
             SOBRE NÓS
        ═══════════════════════════════════════════════════════ --}}
        @if($page === 'about')

            @include('admin.content.partials.section-card', [
                'title'   => 'Hero',
                'icon'    => 'fa-image',
                'section' => 'hero',
                'fields'  => [
                    ['key' => 'title', 'label' => 'Título do Hero', 'type' => 'textarea'],
                    ['key' => 'image', 'label' => 'Imagem de Fundo do Hero', 'type' => 'image'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'A Nossa História',
                'icon'    => 'fa-book-open',
                'section' => 'history',
                'fields'  => [
                    ['key' => 'label',        'label' => 'Etiqueta (tag laranja)',    'type' => 'text'],
                    ['key' => 'title',        'label' => 'Título da Secção',          'type' => 'text'],
                    ['key' => 'text_1',       'label' => 'Parágrafo 1',               'type' => 'textarea'],
                    ['key' => 'text_2',       'label' => 'Parágrafo 2',               'type' => 'textarea'],
                    ['key' => 'stat_1_num',   'label' => 'Estatística 1 — Número',    'type' => 'text', 'hint' => 'Ex: 30+'],
                    ['key' => 'stat_1_label', 'label' => 'Estatística 1 — Legenda',   'type' => 'text', 'hint' => 'Ex: Anos Globais'],
                    ['key' => 'stat_2_num',   'label' => 'Estatística 2 — Número',    'type' => 'text'],
                    ['key' => 'stat_2_label', 'label' => 'Estatística 2 — Legenda',   'type' => 'text'],
                    ['key' => 'image',        'label' => 'Imagem (Equipa / Foto)',     'type' => 'image'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'Em Números',
                'icon'    => 'fa-chart-bar',
                'section' => 'numbers',
                'fields'  => [
                    ['key' => 'stat_1_num',   'label' => 'Número 1',   'type' => 'text', 'hint' => 'Ex: +15'],
                    ['key' => 'stat_1_label', 'label' => 'Legenda 1',  'type' => 'text', 'hint' => 'Ex: Anos no Mercado'],
                    ['key' => 'stat_2_num',   'label' => 'Número 2',   'type' => 'text'],
                    ['key' => 'stat_2_label', 'label' => 'Legenda 2',  'type' => 'text'],
                    ['key' => 'stat_3_num',   'label' => 'Número 3',   'type' => 'text'],
                    ['key' => 'stat_3_label', 'label' => 'Legenda 3',  'type' => 'text'],
                    ['key' => 'stat_4_num',   'label' => 'Número 4',   'type' => 'text'],
                    ['key' => 'stat_4_label', 'label' => 'Legenda 4',  'type' => 'text'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'CTA Final',
                'icon'    => 'fa-bullhorn',
                'section' => 'cta',
                'fields'  => [
                    ['key' => 'title',       'label' => 'Título do CTA',   'type' => 'textarea'],
                    ['key' => 'subtitle',    'label' => 'Subtítulo',        'type' => 'textarea'],
                    ['key' => 'button_text', 'label' => 'Texto do Botão',   'type' => 'text'],
                ],
            ])

        @endif

        {{-- ═══════════════════════════════════════════════════════
             INVESTIDORES
        ═══════════════════════════════════════════════════════ --}}
        @if($page === 'investors')

            @include('admin.content.partials.section-card', [
                'title'   => 'Hero',
                'icon'    => 'fa-image',
                'section' => 'hero',
                'fields'  => [
                    ['key' => 'title',       'label' => 'Título',          'type' => 'textarea'],
                    ['key' => 'subtitle',    'label' => 'Subtítulo',        'type' => 'textarea'],
                    ['key' => 'button_text', 'label' => 'Texto do Botão',   'type' => 'text'],
                    ['key' => 'image',       'label' => 'Imagem de Fundo do Hero', 'type' => 'image'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'Oportunidade de Mercado',
                'icon'    => 'fa-globe',
                'section' => 'opportunity',
                'fields'  => [
                    ['key' => 'title',        'label' => 'Título',               'type' => 'text'],
                    ['key' => 'text_1',       'label' => 'Parágrafo 1',           'type' => 'textarea'],
                    ['key' => 'text_2',       'label' => 'Parágrafo 2',           'type' => 'textarea'],
                    ['key' => 'stat_1_num',   'label' => 'Yield — Número',        'type' => 'text', 'hint' => 'Ex: 12%+'],
                    ['key' => 'stat_1_label', 'label' => 'Yield — Legenda',       'type' => 'text'],
                    ['key' => 'stat_2_num',   'label' => 'Capital Apreciação — Número',  'type' => 'text'],
                    ['key' => 'stat_2_label', 'label' => 'Capital Apreciação — Legenda', 'type' => 'text'],
                    ['key' => 'image',        'label' => 'Imagem Lateral (Interior Premium)', 'type' => 'image'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'Serviços 360°',
                'icon'    => 'fa-circle-nodes',
                'section' => 'services',
                'fields'  => [
                    ['key' => 'title',    'label' => 'Título',     'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtítulo',   'type' => 'textarea'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'Performance Financeira',
                'icon'    => 'fa-chart-line',
                'section' => 'performance',
                'fields'  => [
                    ['key' => 'title',    'label' => 'Título',      'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtítulo',    'type' => 'textarea'],
                    ['key' => 'roi',      'label' => 'ROI Estimado', 'type' => 'text', 'hint' => 'Ex: 15% - 22% p.a.'],
                    ['key' => 'payback',  'label' => 'Payback Period', 'type' => 'text', 'hint' => 'Ex: 6.5 Anos'],
                ],
            ])

        @endif

        {{-- ═══════════════════════════════════════════════════════
             AVALIAÇÃO IMOBILIÁRIA
        ═══════════════════════════════════════════════════════ --}}
        @if($page === 'valuation')

            @include('admin.content.partials.section-card', [
                'title'   => 'Hero',
                'icon'    => 'fa-image',
                'section' => 'hero',
                'fields'  => [
                    ['key' => 'title',       'label' => 'Título',          'type' => 'text'],
                    ['key' => 'subtitle',    'label' => 'Subtítulo',        'type' => 'textarea'],
                    ['key' => 'button_text', 'label' => 'Texto do Botão',   'type' => 'text'],
                    ['key' => 'image',       'label' => 'Imagem de Fundo do Hero', 'type' => 'image'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'Nossa Metodologia',
                'icon'    => 'fa-microscope',
                'section' => 'methodology',
                'fields'  => [
                    ['key' => 'title',    'label' => 'Título',    'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtítulo', 'type' => 'textarea'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'Objectivos da Avaliação',
                'icon'    => 'fa-bullseye',
                'section' => 'objectives',
                'fields'  => [
                    ['key' => 'title',    'label' => 'Título',    'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtítulo', 'type' => 'textarea'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'Modalidades de Serviço',
                'icon'    => 'fa-layer-group',
                'section' => 'modalities',
                'fields'  => [
                    ['key' => 'title', 'label' => 'Título', 'type' => 'text'],
                ],
            ])

        @endif

        {{-- ═══════════════════════════════════════════════════════
             GESTÃO DE PROPRIEDADES
        ═══════════════════════════════════════════════════════ --}}
        @if($page === 'management')

            @include('admin.content.partials.section-card', [
                'title'   => 'Hero',
                'icon'    => 'fa-image',
                'section' => 'hero',
                'fields'  => [
                    ['key' => 'title',       'label' => 'Título',          'type' => 'text'],
                    ['key' => 'subtitle',    'label' => 'Subtítulo',        'type' => 'textarea'],
                    ['key' => 'button_text', 'label' => 'Texto do Botão',   'type' => 'text'],
                    ['key' => 'image',       'label' => 'Imagem de Fundo do Hero', 'type' => 'image'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'O Que Fazemos',
                'icon'    => 'fa-wrench',
                'section' => 'services',
                'fields'  => [
                    ['key' => 'title',    'label' => 'Título',    'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtítulo', 'type' => 'textarea'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'Full-Pack & Foco Corporate',
                'icon'    => 'fa-briefcase',
                'section' => 'fullpack',
                'fields'  => [
                    ['key' => 'title',    'label' => 'Título',    'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Texto',     'type' => 'textarea'],
                    ['key' => 'image',    'label' => 'Imagem de Fundo da Secção', 'type' => 'image'],
                ],
            ])

        @endif

        {{-- ═══════════════════════════════════════════════════════
             PROPRIEDADES & PARCEIROS
        ═══════════════════════════════════════════════════════ --}}
        @if($page === 'partners')

            @include('admin.content.partials.section-card', [
                'title'   => 'Hero',
                'icon'    => 'fa-image',
                'section' => 'hero',
                'fields'  => [
                    ['key' => 'title',       'label' => 'Título',          'type' => 'textarea'],
                    ['key' => 'subtitle',    'label' => 'Subtítulo',        'type' => 'textarea'],
                    ['key' => 'button_text', 'label' => 'Texto do Botão',   'type' => 'text'],
                    ['key' => 'image',       'label' => 'Imagem de Fundo do Hero', 'type' => 'image'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'A Nossa Proposta de Valor',
                'icon'    => 'fa-gem',
                'section' => 'value',
                'fields'  => [
                    ['key' => 'title',    'label' => 'Título',    'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtítulo', 'type' => 'textarea'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'Modelos de Parceria',
                'icon'    => 'fa-diagram-project',
                'section' => 'models',
                'fields'  => [
                    ['key' => 'title',    'label' => 'Título',    'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtítulo', 'type' => 'textarea'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'Como Funciona',
                'icon'    => 'fa-list-ol',
                'section' => 'howworks',
                'fields'  => [
                    ['key' => 'title',    'label' => 'Título',    'type' => 'text'],
                    ['key' => 'subtitle', 'label' => 'Subtítulo', 'type' => 'textarea'],
                ],
            ])

            @include('admin.content.partials.section-card', [
                'title'   => 'Benefícios Full-Pack',
                'icon'    => 'fa-star',
                'section' => 'fullpack',
                'fields'  => [
                    ['key' => 'title',    'label' => 'Título',  'type' => 'textarea'],
                    ['key' => 'subtitle', 'label' => 'Texto',   'type' => 'textarea'],
                ],
            ])

        @endif

        {{-- ═══════════════════════════════════════════════════════
             CATÁLOGO DE IMÓVEIS
        ═══════════════════════════════════════════════════════ --}}
        @if($page === 'imoveis')

            @include('admin.content.partials.section-card', [
                'title'   => 'Cabeçalho & Filtros',
                'icon'    => 'fa-building',
                'section' => 'hero',
                'fields'  => [
                    ['key' => 'title',    'label' => 'Título Principal', 'type' => 'textarea', 'hint' => 'Ex: Encontre o seu Imóvel Ideal'],
                    ['key' => 'subtitle', 'label' => 'Subtítulo',        'type' => 'textarea'],
                    ['key' => 'image',    'label' => 'Imagem Banner (opcional)', 'type' => 'image'],
                ],
            ])

        @endif

        {{-- ═══════════════════════════════════════════════════════
             SEO & META TAGS (Todas as Páginas)
        ═══════════════════════════════════════════════════════ --}}
        @include('admin.content.partials.section-card', [
            'title'   => 'SEO & Meta Tags (Motores de Busca)',
            'icon'    => 'fa-magnifying-glass',
            'section' => 'seo',
            'fields'  => [
                ['key' => 'title',       'label' => 'Meta Title (Título da Aba / Google)', 'type' => 'text',     'hint' => 'Ex: Imóveis em Luanda | Time To Choose'],
                ['key' => 'description', 'label' => 'Meta Description (Resumo no Google)', 'type' => 'textarea', 'hint' => 'Recomendado até 160 caracteres'],
                ['key' => 'keywords',    'label' => 'Palavras-Chave (Keywords)',            'type' => 'text',     'hint' => 'Separadas por vírgula. Ex: imóveis, luanda, arrendamento, venda'],
            ],
        ])

        {{-- Sticky Save Bar --}}
        <div class="sticky bottom-0 bg-white/95 backdrop-blur border-t border-admin-border py-4 px-1 -mx-1 mt-6 flex items-center justify-between gap-4 z-20">
            <p class="text-sm text-admin-muted hidden sm:block">
                <i class="fa-solid fa-circle-info text-brand mr-1"></i>
                As alterações ficam visíveis no site imediatamente após guardar.
            </p>
            <div class="flex items-center gap-3 ml-auto">
                <a href="{{ route('admin.content.index') }}"
                   class="px-5 py-2.5 text-sm font-semibold text-admin-muted hover:text-admin-text border border-admin-border rounded-xl transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-brand hover:bg-brand-dark text-white text-sm font-semibold px-6 py-2.5 rounded-xl flex items-center gap-2 transition shadow-sm">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Guardar Alterações
                </button>
            </div>
        </div>

    </form>

    @push('scripts')
    <script>
    /**
     * Live-preview an image file input into a target element.
     * @param {HTMLInputElement} input
     * @param {string}           previewId  — id of the <img> or container div
     */
    function previewImage(input, previewId) {
        if (!input.files || !input.files[0]) return;
        const file   = input.files[0];
        const reader = new FileReader();
        const wrap   = document.getElementById(previewId + '_wrap');

        reader.onload = function (e) {
            // Replace whatever is inside the wrap with a fresh <img>
            wrap.innerHTML = `
                <img id="${previewId}"
                     src="${e.target.result}"
                     alt="Pré-visualização"
                     class="w-full h-52 object-cover">
                <div class="absolute inset-0 bg-black/0 hover:bg-black/20 transition-colors flex items-center justify-center opacity-0 hover:opacity-100">
                    <span class="bg-white text-xs font-semibold px-3 py-1.5 rounded-full shadow text-admin-text">Clique para substituir</span>
                </div>`;
        };
        reader.readAsDataURL(file);

        // Update the hint text below
        const hint = input.closest('div.md\\:col-span-2, div:not([class])').querySelector('.field-hint');
        if (hint) {
            hint.innerHTML = `<i class="fa-solid fa-circle-check text-brand text-[9px]"></i> <strong>${file.name}</strong> selecionado — será guardado ao submeter.`;
        }
    }
    </script>
    @endpush

</x-admin.layout>
