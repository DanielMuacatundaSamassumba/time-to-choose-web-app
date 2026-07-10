<x-layouts.app title="Proprietários e Parceiros" description="O seu imóvel merece uma gestão profissional. Trabalhamos lado a lado consigo para rentabilizar e gerir o seu património.">

    <!-- Hero Section -->
    <section class="relative w-full min-h-[600px] flex items-center justify-center pt-20 pb-20 overflow-hidden">
        <div class="absolute inset-0 bg-black/60 z-10"></div>
        <div class="absolute top-0 left-0 right-0 bottom-0 bg-cover bg-center"
            style="background-image: url('{{ asset('assets/An_ultra-realistic_luxury_real_estate_202607021617.jpeg') }}');">
        </div>
        <div class="relative z-20 max-w-7xl mx-auto px-6 md:px-12 w-full grid grid-cols-1 md:grid-cols-12 gap-8 items-center text-white">
            <div class="md:col-span-8 flex flex-col gap-6 reveal">
                <h1 class="text-4xl md:text-6xl font-bold leading-tight">
                    O seu imóvel merece uma gestão profissional.
                </h1>
                <p class="text-lg text-white/90 max-w-2xl leading-relaxed">
                    Na Time To Choose, valorizamos relações sólidas e duradouras com proprietários e parceiros,
                    baseadas em transparência, confiança e resultados. Trabalhamos lado a lado com cada cliente para
                    transformar imóveis em activos rentáveis, assegurando uma gestão profissional e uma ocupação eficiente.
                </p>
                <div class="flex flex-wrap gap-4 mt-4">
                    <button class="bg-[#FF6B00] text-white px-8 py-4 rounded-lg font-bold hover:bg-orange-600 transition">
                        Agendar Reunião
                    </button>
                </div>
            </div>
            <div class="md:col-span-4 mt-12 md:mt-0 reveal" style="transition-delay: .2s">
                <div class="bg-white rounded-2xl p-8 shadow-xl flex flex-col gap-6 text-gray-800">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-lg font-bold text-gray-900">Gestão de Arrendamento</span>
                        </div>
                        <p class="text-sm text-gray-500 leading-relaxed">Gerimos o seu imóvel e tratamos de todo o processo de arrendamento.</p>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-lg font-bold text-gray-900">Full-Pack Residencial</span>
                        </div>
                        <p class="text-sm text-gray-500 leading-relaxed">Transformamos o imóvel num produto premium com serviços integrados, aumentando o valor e a procura.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Proposta de Valor Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 w-full">
            <div class="text-center mb-12 reveal">
                <h2 class="font-bold text-4xl text-gray-900 mb-4">A Nossa Proposta de Valor</h2>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                    Três pilares fundamentais para garantir o sucesso do seu investimento imobiliário.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center gap-4 reveal">
                    <span class="material-symbols-outlined text-[#FF6B00] text-5xl">shield_lock</span>
                    <h3 class="text-xl font-bold text-gray-900">Segurança</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Foco total no pagamento pontual e seguro das rendas, mitigando riscos para o proprietário.</p>
                </div>
                <div class="bg-gray-50 p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center gap-4 reveal" style="transition-delay: .15s">
                    <span class="material-symbols-outlined text-[#FF6B00] text-5xl">trending_up</span>
                    <h3 class="text-xl font-bold text-gray-900">Rentabilidade</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Maximizamos o retorno do seu investimento através de uma gestão eficiente e ocupação otimizada.</p>
                </div>
                <div class="bg-gray-50 p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center gap-4 reveal" style="transition-delay: .3s">
                    <span class="material-symbols-outlined text-[#FF6B00] text-5xl">person_off</span>
                    <h3 class="text-xl font-bold text-gray-900">Zero Gestão</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Deixe tudo connosco. Tratamos de toda a burocracia, manutenção e relação com os inquilinos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modelos de Parceria Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 md:px-12 w-full">
            <div class="text-center mb-12 reveal">
                <h2 class="font-bold text-4xl text-gray-900 mb-4">Modelos de Parceria</h2>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">Soluções adaptadas aos seus objetivos de investimento.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Modelo 1 -->
                <div class="group relative h-[450px] overflow-hidden rounded-2xl cursor-pointer shadow-md hover:-translate-y-2 hover:shadow-2xl transition duration-500">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 ease-out group-hover:scale-110"
                        style="background-image: url('{{ asset('assets/1.jpeg') }}');"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/55 to-black/20 group-hover:from-black/90 group-hover:via-black/70 transition duration-500"></div>
                    <div class="relative z-10 flex flex-col justify-end h-full p-8 text-white transition duration-500">
                        <span class="text-[#FF6B00] font-semibold uppercase tracking-widest text-xs mb-2 block">Renda Fixa Garantida</span>
                        <h3 class="text-2xl font-bold mb-4 group-hover:text-[#FF6B00] transition">Subarrendamento</h3>
                        <p class="text-white/90 leading-relaxed text-sm">Assumimos o arrendamento do seu imóvel e garantimos o pagamento de uma renda fixa mensal, independentemente da ocupação.</p>
                    </div>
                </div>

                <!-- Modelo 2 -->
                <div class="group relative h-[450px] overflow-hidden rounded-2xl cursor-pointer shadow-md hover:-translate-y-2 hover:shadow-2xl transition duration-500" style="transition-delay: .1s">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 ease-out group-hover:scale-110"
                        style="background-image: url('{{ asset('assets/2.jpeg') }}');"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/55 to-black/20 group-hover:from-black/90 group-hover:via-black/70 transition duration-500"></div>
                    <div class="relative z-10 flex flex-col justify-end h-full p-8 text-white transition duration-500">
                        <span class="text-[#FF6B00] font-semibold uppercase tracking-widest text-xs mb-2 block">Investidores e Promotores</span>
                        <h3 class="text-2xl font-bold mb-4 group-hover:text-[#FF6B00] transition">Parcerias</h3>
                        <p class="text-white/90 leading-relaxed text-sm">Desenvolvemos parcerias estratégicas para maximizar o potencial de ativos imobiliários de maior dimensão.</p>
                    </div>
                </div>

                <!-- Modelo 3 -->
                <div class="group relative h-[450px] overflow-hidden rounded-2xl cursor-pointer shadow-md hover:-translate-y-2 hover:shadow-2xl transition duration-500" style="transition-delay: .2s">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 ease-out group-hover:scale-110"
                        style="background-image: url('{{ asset('assets/3.jpeg') }}');"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/55 to-black/20 group-hover:from-black/90 group-hover:via-black/70 transition duration-500"></div>
                    <div class="relative z-10 flex flex-col justify-end h-full p-8 text-white transition duration-500">
                        <span class="text-[#FF6B00] font-semibold uppercase tracking-widest text-xs mb-2 block">Percentagem sobre Receitas</span>
                        <h3 class="text-2xl font-bold mb-4 group-hover:text-[#FF6B00] transition">Gestão de Património</h3>
                        <p class="text-white/90 leading-relaxed text-sm">Gerimos o seu imóvel e cobramos uma taxa de gestão sobre os rendimentos gerados, alinhando o nosso sucesso com o seu.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Como Funciona Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 w-full">
            <div class="text-center mb-16">
                <h2 class="font-bold text-4xl text-gray-900 mb-4">Como Funciona</h2>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">Um processo simples e transparente em 4 passos.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @foreach([
                    ['num' => '1', 'title' => 'Avaliação', 'desc' => 'Analisamos o potencial do seu imóvel e definimos o valor de mercado ótimo.'],
                    ['num' => '2', 'title' => 'Estratégia', 'desc' => 'Selecionamos o modelo de parceria mais adequado aos seus objetivos.'],
                    ['num' => '3', 'title' => 'Preparação', 'desc' => 'Preparamos o imóvel, desde pequenas reparações à implementação do Full-Pack se necessário.'],
                    ['num' => '4', 'title' => 'Gestão', 'desc' => 'Iniciamos a operação, tratando de tudo enquanto recebe os seus rendimentos.']
                ] as $step)
                <div class="flex flex-col items-center text-center bg-gray-50 p-6 rounded-2xl hover:-translate-y-2 hover:shadow-lg transition duration-300 cursor-pointer">
                    <div class="w-16 h-16 rounded-full bg-[#FF6B00] text-white flex items-center justify-center font-bold text-2xl mb-6 shadow-md">
                        {{ $step['num'] }}
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $step['title'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Benefícios Full-Pack Section -->
    <section class="relative overflow-hidden py-24 bg-cover bg-center"
        style="background-image: url('{{ asset('assets/Property_manager_discussing_perf…_202607021718.jpeg') }}');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#0D0D0D]/90 via-[#0D0D0D]/75 to-[#0D0D0D]/40"></div>

        <!-- Conteúdo -->
        <div class="relative z-10 max-w-7xl mx-auto px-6">
            <div class="max-w-2xl backdrop-blur-md bg-white/10 border border-white/10 rounded-3xl p-10 shadow-2xl">
                <h2 class="text-3xl md:text-4xl font-bold leading-tight text-white mb-6">
                    Benefícios que transformam o seu imóvel numa experiência premium.
                </h2>
                <p class="text-base leading-relaxed text-white/80 mb-10">
                    Transformamos propriedades comuns em experiências habitacionais exclusivas, aumentando o valor
                    do seu património através de uma gestão integrada, serviços premium e elevados padrões de qualidade.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach([
                        'Mobiliário de Design', 'Manutenção Preventiva',
                        'Internet de Alta Velocidade + TV', 'Serviço de Limpeza Regular',
                        'Sistemas de Segurança', 'Serviços Premium On-Demand'
                    ] as $beneficio)
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-white text-sm" style="font-variation-settings: 'FILL' 1">check_circle</span>
                        <span class="text-white text-sm font-medium">{{ $beneficio }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="py-16 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <p class="text-center text-xs font-semibold text-gray-400 uppercase tracking-widest mb-10">Parcerias Estratégicas</p>
            <div class="flex flex-wrap justify-center items-center gap-16 grayscale opacity-50 hover:grayscale-0 transition duration-300">
                @for ($i = 0; $i < 4; $i++)
                <div>
                    <img src="{{ asset('assets/Logo_Time.png') }}" alt="Parceiro" class="h-10">
                </div>
                @endfor
            </div>
        </div>
    </section>

</x-layouts.app>