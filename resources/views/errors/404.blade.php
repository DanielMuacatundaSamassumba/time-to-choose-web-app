<x-layouts.app title="404 - Página Não Encontrada | Time To Choose" description="A página que procura não existe ou foi removida.">

    <section class="min-h-[75vh] flex items-center justify-center py-20 px-4">
        <div class="max-w-2xl mx-auto text-center">
            {{-- Big 404 Badge with Brand Styling --}}
            <div class="relative inline-block mb-6">
                <span class="text-8xl sm:text-9xl font-black text-[#F97316]/15 select-none tracking-widest">
                    404
                </span>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-20 h-20 rounded-3xl bg-[#F97316]/10 text-[#F97316] flex items-center justify-center shadow-inner">
                        <i class="fa-solid fa-house-crack text-3xl sm:text-4xl text-[#F97316]"></i>
                    </div>
                </div>
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">
                Página Não Encontrada
            </h1>

            <p class="text-gray-500 text-base sm:text-lg max-w-md mx-auto mb-8 leading-relaxed">
                Lamentamos, mas o imóvel ou a página que procura pode ter sido removida, alterada de endereço ou não estar temporariamente disponível.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('home') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-sm bg-[#F97316] hover:bg-[#F97316]/90 text-white font-bold text-sm shadow-lg shadow-[#F97316]/25 transition-all transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-house text-sm"></i>
                    Página Inicial
                </a>

                <a href="{{ route('properties.index') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-sm border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-bold text-sm shadow-sm transition-all transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-magnifying-glass text-sm text-[#F97316]"></i>
                    Explorar Imóveis
                </a>
            </div>

            {{-- Quick links suggestion --}}
            <div class="mt-12 pt-8 border-t border-gray-100 flex flex-wrap justify-center items-center gap-6 text-xs text-gray-500">
                <span class="font-semibold text-gray-400 uppercase tracking-wider">Links Úteis:</span>
                <a href="{{ route('about') }}" class="hover:text-[#F97316] transition">Sobre Nós</a>
                <a href="{{ route('investers') }}" class="hover:text-[#F97316] transition">Investidores</a>
                <a href="{{ route('manager-property') }}" class="hover:text-[#F97316] transition">Gestão de Imóveis</a>
                <a href="{{ route('imovel-avaliation') }}" class="hover:text-[#F97316] transition">Avaliação de Imóvel</a>
            </div>
        </div>
    </section>

</x-layouts.app>
