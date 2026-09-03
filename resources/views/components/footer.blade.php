{{-- ======================================================
COMPONENTE: Footer Global
Uso: <x-footer />
====================================================== --}}

<footer class="bg-[#0f0f0f] text-white ">

    <div class="w-full max-w-7xl mx-auto px-6 lg:px-8 pt-20 pb-10">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:gap-16">

            {{-- Logo + Descrição --}}
            <div class="lg:col-span-1">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/Logo_Time.png') }}" alt="Time To Choose"
                        class="h-16 mb-6 brightness-0 invert">
                </a>
                <p class="text-white/60 leading-7 text-sm">
                    A Time To Choose é uma empresa especializada em mediação, gestão e consultoria imobiliária,
                    ajudando clientes a encontrar as melhores oportunidades do mercado angolano.
                </p>
                {{-- Redes Sociais --}}
                <div class="flex gap-4 mt-8">
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center
                              hover:bg-[#F97316] transition duration-300">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center
                              hover:bg-[#F97316] transition duration-300">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center
                              hover:bg-[#F97316] transition duration-300">
                        <i class="fab fa-linkedin-in text-sm"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center
                              hover:bg-[#F97316] transition duration-300">
                        <i class="fab fa-whatsapp text-sm"></i>
                    </a>
                </div>
            </div>

            {{-- Links Rápidos --}}
            <div>
                <h3 class="font-bold text-lg mb-6 uppercase tracking-widest text-white/90">Links Rápidos</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ url('/imoveis') }}?category=venda"
                            class="text-white/60 hover:text-[#F97316] transition duration-200 text-sm flex items-center gap-2">

                           Venda
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/imoveis') }}?category=arrendamento-longa-duracao"
                            class="text-white/60 hover:text-[#F97316] transition duration-200 text-sm flex items-center gap-2">

                            Arrendamento Longa Duração
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/imoveis') }}?category=arrendamento-curta-duracao"
                            class="text-white/60 hover:text-[#F97316] transition duration-200 text-sm flex items-center gap-2">

                            Arrendamento Curta Duração
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/sobre-nos') }}"
                            class="text-white/60 hover:text-[#F97316] transition duration-200 text-sm flex items-center gap-2">

                            Quem Somos
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/investidores') }}"
                            class="text-white/60 hover:text-[#F97316] transition duration-200 text-sm flex items-center gap-2">

                            Investidores
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/gestao-de-propriedades') }}"
                            class="text-white/60 hover:text-[#F97316] transition duration-200 text-sm flex items-center gap-2">

                            Gestão de Propriedades
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/avaliacao-de-imoveis') }}"
                            class="text-white/60 hover:text-[#F97316] transition duration-200 text-sm flex items-center gap-2">

                            Avaliação Imobiliária
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/propriedades-e-parceiros') }}"
                            class="text-white/60 hover:text-[#F97316] transition duration-200 text-sm flex items-center gap-2">

                            Proprietários & Parceiros
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Serviços --}}
            <!-- <div>
                <h3 class="font-bold text-lg mb-6 uppercase tracking-widest text-white/90">Serviços</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="#"
                            class="text-white/60 hover:text-[#F97316] transition duration-200 text-sm flex items-center gap-2">

                            Mediação Imobiliária
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-white/60 hover:text-[#F97316] transition duration-200 text-sm flex items-center gap-2">

                            Consultoria Corporativa
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-white/60 hover:text-[#F97316] transition duration-200 text-sm flex items-center gap-2">

                            Avaliação de Imóveis
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-white/60 hover:text-[#F97316] transition duration-200 text-sm flex items-center gap-2">

                            Gestão de Património
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-white/60 hover:text-[#F97316] transition duration-200 text-sm flex items-center gap-2">

                            Apoio a Investidores
                        </a>
                    </li>
                </ul>
            </div> -->

            {{-- Contactos --}}
            <div>
                <h3 class="font-bold text-lg mb-6 uppercase tracking-widest text-white/90">Contactos</h3>
                <ul class="space-y-2">
                    <li class="flex items-start gap-4">

                        <div>
                            <p class="text-white/90 text-sm font-medium">Endereço</p>
                            <p class="text-white/50 text-sm">{{ $globalSettings['address'] ?? 'Talatona, Luanda, Angola' }}</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-4">

                        <div>
                            <p class="text-white/90 text-sm font-medium">Telefone</p>
                            <a href="tel:{{ $globalSettings['phone'] ?? '+244923000000' }}" class="text-white/50 text-sm hover:text-[#F97316] transition">{{ $globalSettings['phone'] ?? '+244 923 000 000' }}</a>
                               
                    </li>
                    <li class="flex items-start gap-4">

                        <div>
                            <p class="text-white/90 text-sm font-medium">Email</p>
                            <a href="mailto:{{ $globalSettings['email'] ?? 'info@timetochoose.ao' }}" class="text-white/50 text-sm hover:text-[#F97316] transition">{{ $globalSettings['email'] ?? 'info@timetochoose.ao' }}</a>
                        </div>
                    </li>
                    <li class="flex items-start gap-4">

                        <!-- <div>
                            <p class="text-white/90 text-sm font-medium">Website</p>
                            <a href="https://www.timetochoose.ao"
                                class="text-white/50 text-sm hover:text-[#F97316] transition">
                                www.timetochoose.ao
                            </a>
                        </div> -->
                    </li>
                </ul>
            </div>

        </div>

    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-white/5  bg-[#DDDDDD]">
        <div class="w-full max-w-7xl mx-auto px-6 lg:px-8 py-6
                    flex flex-col lg:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} Time To Choose. Todos os direitos reservados.
            </p>
            <div class="flex items-center gap-6 text-gray-500 text-sm">
                <!--<x-language-switcher :dropUp="true" />-->
                <a href="#" class="hover:text-[#F97316] transition duration-200">Política de Privacidade</a>
                <a href="#" class="hover:text-[#F97316] transition duration-200">Termos de Utilização</a>
                <a href="#" class="hover:text-[#F97316] transition duration-200">Cookies</a>
            </div>
        </div>
    </div>

</footer>