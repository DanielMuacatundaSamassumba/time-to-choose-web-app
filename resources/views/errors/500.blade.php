<x-layouts.app title="500 - Erro Interno | Time To Choose" description="Ocorreu um erro no servidor.">

    <section class="min-h-[75vh] flex items-center justify-center py-20 px-4">
        <div class="max-w-2xl mx-auto text-center">
            <div class="relative inline-block mb-6">
                <span class="text-8xl sm:text-9xl font-black text-red-500/15 select-none tracking-widest">
                    500
                </span>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-20 h-20 rounded-3xl bg-red-50 text-red-600 flex items-center justify-center shadow-inner">
                        <i class="fa-solid fa-triangle-exclamation text-3xl sm:text-4xl"></i>
                    </div>
                </div>
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">
                Erro no Servidor
            </h1>

            <p class="text-gray-500 text-base sm:text-lg max-w-md mx-auto mb-8 leading-relaxed">
                Pedimos desculpa pelo transtorno. Ocorreu uma falha temporária no processamento do pedido. Por favor, tente novamente mais tarde.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('home') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-[#F97316] hover:bg-[#F97316]/90 text-white font-bold text-sm shadow-lg shadow-[#F97316]/25 transition-all">
                    <i class="fa-solid fa-house text-sm"></i>
                    Voltar ao Início
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
