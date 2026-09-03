{{-- ======================================================
COMPONENTE: Header Global
Uso: <x-header />
Props opcionais: $transparent (bool) - usa header transparente sobre hero
====================================================== --}}
@props(['transparent' => false])

<style>
    .menu-line {
        transition: all .35s cubic-bezier(.22, 1, .36, 1);
        display: block;
    }

    .menu-open .menu-line:nth-child(1) {
        transform: translateY(8px) rotate(45deg);
    }

    .menu-open .menu-line:nth-child(2) {
        opacity: 0;
    }

    .menu-open .menu-line:nth-child(3) {
        transform: translateY(-8px) rotate(-45deg);
    }

    .hero-line {
        position: absolute;
        width: 32px;
        height: 2px;
        background: #fff;
        border-radius: 999px;
        transition: .35s ease;
    }

    .hero-line:nth-child(1) {
        transform: translateY(-8px);
    }

    .hero-line:nth-child(2) {
        transform: translateY(0);
    }

    .hero-line:nth-child(3) {
        transform: translateY(8px);
    }

    #hero-menu-btn.active .hero-line:nth-child(1) {
        transform: rotate(45deg);
    }

    #hero-menu-btn.active .hero-line:nth-child(2) {
        opacity: 0;
    }

    #hero-menu-btn.active .hero-line:nth-child(3) {
        transform: rotate(-45deg);
    }
</style>

{{-- ======================================================
STICKY HEADER (aparece ao rolar)
====================================================== --}}
<div id="sticky-header" class="fixed top-0 left-0 w-full z-50
            bg-white shadow-lg border-b border-gray-100
            -translate-y-full opacity-0
            transition-all duration-500">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-10">
                {{-- Logo --}}
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/Logo_Time.png') }}" alt="Time To Choose" class="w-20 md:w-[130px]">
                </a>
                {{-- Nav Desktop --}}
                <nav class="hidden lg:flex items-center gap-2 font-semibold uppercase text-sm">
                    <a href="{{ url('/imoveis') }}?category=venda" class="{{ request()->is('/') && !request()->has('category') ? 'bg-[#F97316] text-white' : 'text-black hover:bg-[#F97316] hover:text-white' }}
                              p-2 px-4 rounded-full transition duration-300">
                       Venda
                    </a>
                    <a href="{{ url('/imoveis') }}?category=arrendamento-longa-duracao" class="{{ request('category') === 'arrendamento-longa-duracao' ? 'bg-[#F97316] text-white' : 'text-black hover:bg-[#F97316] hover:text-white' }}
                              p-2 px-4 rounded-full transition duration-300">
                       Arrendamento de Longa Duração
                    </a>
                    <a href="{{ url('/imoveis') }}?category=arrendamento-curta-duracao" class="{{ request('category') === 'arrendamento-curta-duracao' ? 'bg-[#F97316] text-white' : 'text-black hover:bg-[#F97316] hover:text-white' }}
                              p-2 px-4 rounded-full transition duration-300">
                        Arrendamento de Curta Duração
                    </a>
                    <!-- <a href="{{ url('/sobre-nos') }}"
                       class="{{ request()->is('sobre-nos') ? 'bg-[#F97316] text-white' : 'text-black hover:bg-[#F97316] hover:text-white' }}
                              p-2 px-4 rounded-full transition duration-300">
                        Quem Somos
                    </a> -->
                    <!-- <a href="{{ url('/investidores') }}"
                       class="{{ request()->is('investidores') ? 'bg-[#F97316] text-white' : 'text-black hover:bg-[#F97316] hover:text-white' }}
                              p-2 px-4 rounded-full transition duration-300">
                        Investidores
                    </a> -->
                </nav>
            </div>
            <div class="flex items-center gap-3">
                <x-language-switcher />
                {{-- Menu mobile btn (sticky) --}}
                <button id="sticky-menu-btn"
                    class="relative w-12 h-12 flex flex-col items-center justify-center gap-[6px] lg:hidden">
                    <span class="menu-line w-8 h-[2px] bg-black rounded-full"></span>
                    <span class="menu-line w-8 h-[2px] bg-black rounded-full"></span>
                    <span class="menu-line w-8 h-[2px] bg-black rounded-full"></span>
                </button>
                {{-- Aside btn (desktop) --}}
                <button id="aside-menu-btn"
                    class="relative w-12 h-12 hidden lg:flex flex-col items-center justify-center gap-[6px]">
                    <span class="menu-line w-8 h-[2px] bg-[#F97316] rounded-full"></span>
                    <span class="menu-line w-8 h-[2px] bg-[#F97316] rounded-full"></span>
                    <span class="menu-line w-8 h-[2px] bg-[#F97316] rounded-full"></span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ======================================================
HEADER NORMAL (visível no topo ou transparente sobre hero)
====================================================== --}}
<header id="main-header"
    class="{{ $transparent ? 'absolute top-0 left-0 w-full z-50' : 'w-full bg-white border-b border-gray-100 shadow-sm' }}">

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-5 flex items-center justify-between">

        {{-- Logo --}}
        <div class="flex items-center gap-8">

            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/Logo_Time.png') }}"
                    alt="Time To Choose"
                    class="{{ $transparent ? 'h-14 lg:h-16 brightness-0 invert' : 'h-12 lg:h-14' }}">
            </a>

            {{-- Nav Desktop --}}
            <nav class="hidden lg:flex items-center gap-2 font-semibold uppercase text-sm">

                {{-- Venda --}}
                <a href="{{ url('/imoveis') }}?category=venda"
                    class="{{ request('category') === 'venda'
                        ? 'bg-[#F97316] text-white'
                        : ($transparent
                            ? 'text-white hover:bg-[#F97316] hover:text-white'
                            : 'text-black hover:bg-[#F97316] hover:text-white') }}
                        p-2 px-4 rounded-full transition duration-300">
                    Venda
                </a>

                {{-- Arrendamento de Longa Duração --}}
                <a href="{{ url('/imoveis') }}?category=arrendamento-longa-duracao"
                    class="{{ request('category') === 'arrendamento-longa-duracao'
                        ? 'bg-[#F97316] text-white'
                        : ($transparent
                            ? 'text-white hover:bg-[#F97316] hover:text-white'
                            : 'text-black hover:bg-[#F97316] hover:text-white') }}
                        p-2 px-4 rounded-full transition duration-300">
                    Arrendamento de Longa Duração
                </a>

                {{-- Arrendamento de Curta Duração --}}
                <a href="{{ url('/imoveis') }}?category=arrendamento-curta-duracao"
                    class="{{ request('category') === 'arrendamento-curta-duracao'
                        ? 'bg-[#F97316] text-white'
                        : ($transparent
                            ? 'text-white hover:bg-[#F97316] hover:text-white'
                            : 'text-black hover:bg-[#F97316] hover:text-white') }}
                        p-2 px-4 rounded-full transition duration-300">
                    Arrendamento de Curta Duração
                </a>

                {{--
                <a href="{{ url('/sobre-nos') }}"
                    class="{{ request()->is('sobre-nos')
                        ? 'bg-[#F97316] text-white'
                        : ($transparent
                            ? 'text-white hover:bg-[#F97316] hover:text-white'
                            : 'text-black hover:bg-[#F97316] hover:text-white') }}
                    p-2 px-4 rounded-full transition duration-300">
                    Quem Somos
                </a>
                --}}

                {{--
                <a href="{{ url('/investidores') }}"
                    class="{{ request()->is('investidores')
                        ? 'bg-[#F97316] text-white'
                        : ($transparent
                            ? 'text-white hover:bg-[#F97316] hover:text-white'
                            : 'text-black hover:bg-[#F97316] hover:text-white') }}
                    p-2 px-4 rounded-full transition duration-300">
                    Investidores
                </a>
                --}}

            </nav>
        </div>

        {{-- Menu buttons --}}
        <div class="flex items-center gap-3">
            <x-language-switcher :transparent="$transparent" />

    {{-- Mobile btn (hambúrguer) --}}
<button id="hero-menu-btn"
    type="button"
    class="block lg:hidden relative w-12 h-12 flex flex-col items-center justify-center gap-1 z-[10001]">

    <span class="block w-8 h-[3px] bg-black !opacity-100"></span>
    <span class="block w-8 h-[3px] bg-black !opacity-100"></span>
    <span class="block w-8 h-[3px] bg-black !opacity-100"></span>

</button>

    {{-- Aside btn (desktop) --}}
    <button id="aside-menu-btn-2"
        class="hidden lg:flex w-12 h-12 flex-col items-center justify-center gap-[6px]">

        <span class="menu-line w-8 h-[2px] {{ $transparent ? 'bg-white' : 'bg-[#F97316]' }} rounded-full"></span>

        <span class="menu-line w-8 h-[2px] {{ $transparent ? 'bg-white' : 'bg-[#F97316]' }} rounded-full"></span>

        <span class="menu-line w-8 h-[2px] {{ $transparent ? 'bg-white' : 'bg-[#F97316]' }} rounded-full"></span>

    </button>

</div>
    </div>
</header>

{{-- ======================================================
MENU MOBILE (slide-in)
====================================================== --}}
<div id="mobile-menu" class="fixed inset-0 bg-white z-[9999]
            translate-x-full opacity-0
            transition-all duration-500 lg:hidden">
    <div class="h-full flex flex-col">
        {{-- Topo --}}
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/Logo_Time.png') }}" alt="Time To Choose" class="w-28">
            </a>
            <button id="close-mobile-menu"
                class="w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center text-black text-2xl hover:bg-gray-50 transition">
                &times;
            </button>
        </div>
        {{-- Links --}}
        <nav class="flex flex-col p-6 gap-1">
            <a href="{{ url('/imoveis') }}?category=venda"
                class="py-4 px-4 rounded-xl text-lg font-semibold {{ request()->is('/') && !request()->has('category') ? 'text-[#F97316] bg-[#F97316]/10' : 'text-gray-800 hover:text-[#F97316] hover:bg-[#F97316]/10' }} transition duration-200">
              Venda
            </a> 
          <a  href="{{ url('/imoveis') }}?category=arrendamento-longa-duracao"
                class="py-4 px-4 rounded-xl text-lg font-semibold {{ request('category') === 'longa-duracao' ? 'text-[#F97316] bg-[#F97316]/10' : 'text-gray-800 hover:text-[#F97316] hover:bg-[#F97316]/10' }} transition duration-200">
            Arrendamento de Longa Duração
            </a> 
        <a  href="{{ url('/imoveis') }}?category=arrendamento-curta-duracao"
                class="py-4 px-4 rounded-xl text-lg font-semibold {{ request('category') === 'curta-duracao' ? 'text-[#F97316] bg-[#F97316]/10' : 'text-gray-800 hover:text-[#F97316] hover:bg-[#F97316]/10' }} transition duration-200">
                Arrendamento Curta Duração
            </a> 
              <a href="{{ url('/propriedades-e-parceiros') }}"
                class="py-4 px-4 rounded-xl text-lg font-semibold {{ request()->is('propriedades-e-parceiros') ? 'text-[#F97316] bg-[#F97316]/10' : 'text-gray-800 hover:text-[#F97316] hover:bg-[#F97316]/10' }} transition duration-200">
                Proprietários &amp; Parceiros
            </a>
             <a href="{{ url('/avaliacao-de-imoveis') }}" class="flex items-center gap-3 p-4 rounded-xl text-lg font-semibold
                          {{ request()->is('avaliacao-de-imoveis') ? 'text-[#F97316] bg-[#F97316]/10' : 'text-gray-800 hover:text-[#F97316] hover:bg-[#F97316]/10' }}
                          transition duration-200">

                    Avaliação Imobiliária
                </a>
            <!-- <a href="{{ url('/sobre-nos') }}"
                class="py-4 px-4 rounded-xl text-lg font-semibold {{ request()->is('sobre-nos') ? 'text-[#F97316] bg-[#F97316]/10' : 'text-gray-800 hover:text-[#F97316] hover:bg-[#F97316]/10' }} transition duration-200">
                Quem Somos
            </a> -->
              <a href="{{ url('/gestao-de-propriedades') }}"
                class="py-4 px-4 rounded-xl text-lg font-semibold {{ request()->is('gestao-de-propriedades') ? 'text-[#F97316] bg-[#F97316]/10' : 'text-gray-800 hover:text-[#F97316] hover:bg-[#F97316]/10' }} transition duration-200">
                Gestão de Propriedades
            </a>
            <a href="{{ url('/investidores') }}"
                class="py-4 px-4 rounded-xl text-lg font-semibold {{ request()->is('investidores') ? 'text-[#F97316] bg-[#F97316]/10' : 'text-gray-800 hover:text-[#F97316] hover:bg-[#F97316]/10' }} transition duration-200">
                Investidores
            </a>
          
          
        </nav>
        {{-- Rodapé do menu --}}
        <div class="mt-auto p-6 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-400">{{ $globalSettings['phone'] ?? '+244 923 000 000' }}</p>
            <x-language-switcher :dropUp="true" />
        </div>
    </div>
</div>

{{-- ======================================================
OVERLAY + ASIDE LATERAL (Desktop)
====================================================== --}}
<div id="desktop-overlay" class="fixed inset-0 bg-black/50 opacity-0 invisible transition-all duration-300 z-40">
</div>

<aside id="desktop-aside" class="fixed top-0 right-0 h-screen w-[380px] bg-white shadow-2xl
              translate-x-full transition-transform duration-500 z-50 overflow-y-auto">
    <div class="flex items-center justify-between p-8 border-b border-gray-100">
        <h2 class="text-2xl font-bold text-gray-900">Menu</h2>
        <button id="close-aside"
            class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition text-xl">
            &times;
        </button>
    </div>
    <nav class="p-8">
        <ul class="space-y-2">
       
         <li>
                <a href="{{ url('/propriedades-e-parceiros') }}" class="flex items-center gap-3 p-4 rounded-xl text-lg font-semibold
                          {{ request()->is('propriedades-e-parceiros') ? 'text-[#F97316] bg-[#F97316]/10' : 'text-gray-800 hover:text-[#F97316] hover:bg-[#F97316]/10' }}
                          transition duration-200">
                  
                    Proprietários & Parceiros
                </a>
            </li>
             <li>
                <a href="{{ url('/avaliacao-de-imoveis') }}" class="flex items-center gap-3 p-4 rounded-xl text-lg font-semibold
                          {{ request()->is('avaliacao-de-imoveis') ? 'text-[#F97316] bg-[#F97316]/10' : 'text-gray-800 hover:text-[#F97316] hover:bg-[#F97316]/10' }}
                          transition duration-200">

                    Avaliação Imobiliária
                </a>
            </li>
           
            <li>
                <a href="{{ url('/gestao-de-propriedades') }}" class="flex items-center gap-3 p-4 rounded-xl text-lg font-semibold
                          {{ request()->is('gestao-de-propriedades') ? 'text-[#F97316] bg-[#F97316]/10' : 'text-gray-800 hover:text-[#F97316] hover:bg-[#F97316]/10' }}
                          transition duration-200">
                 
                    Gestão de Propriedades
                </a>
            </li>
            <li>
                <a href="{{ url('/investidores') }}" class="flex items-center gap-3 p-4 rounded-xl text-lg font-semibold
                          {{ request()->is('investidores') ? 'text-[#F97316] bg-[#F97316]/10' : 'text-gray-800 hover:text-[#F97316] hover:bg-[#F97316]/10' }}
                          transition duration-200">
   
                    Investidores
                </a>
            </li>
          
        </ul>
    </nav>
    <div class="px-8 pb-8">
        <div class="bg-[#F97316]/10 rounded-2xl p-6">
            <p class="text-sm text-gray-500 font-semibold uppercase mb-2">Contactos</p>
            <p class="text-gray-800 font-medium">{{ $globalSettings['phone'] ?? '+244 923 000 000' }}</p>
        <p class="text-gray-500 text-sm">{{ $globalSettings['email'] ?? 'info@timetochoose.ao' }}</p>
        </div>
    </div>
</aside>

{{-- ======================================================
SCRIPTS DO HEADER
====================================================== --}}


<script>
(function () {

    // =====================================================
    // STICKY HEADER AO ROLAR
    // =====================================================

    const stickyHeader = document.getElementById('sticky-header');

    window.addEventListener('scroll', function () {

        if (!stickyHeader) return;

        if (window.scrollY > 300) {

            stickyHeader.classList.remove(
                '-translate-y-full',
                'opacity-0'
            );

            stickyHeader.classList.add(
                'translate-y-0',
                'opacity-100'
            );

        } else {

            stickyHeader.classList.add(
                '-translate-y-full',
                'opacity-0'
            );

            stickyHeader.classList.remove(
                'translate-y-0',
                'opacity-100'
            );
        }
    });


    // =====================================================
    // MOBILE MENU
    // =====================================================

    const heroMenuBtn = document.getElementById('hero-menu-btn');
    const stickyMenuBtn = document.getElementById('sticky-menu-btn');

    const mobileMenu = document.getElementById('mobile-menu');
    const closeMobile = document.getElementById('close-mobile-menu');


    // -----------------------------------------------------
    // ABRIR MENU MOBILE
    // -----------------------------------------------------

    function openMobileMenu() {

        if (!mobileMenu) return;

        // Abrir o slide
        mobileMenu.classList.remove(
            'translate-x-full',
            'opacity-0'
        );

        mobileMenu.classList.add(
            'translate-x-0',
            'opacity-100'
        );

        // Esconder o hambúrguer
        if (heroMenuBtn) {
            heroMenuBtn.classList.add('hidden');
        }

        // Bloquear scroll
        document.body.style.overflow = 'hidden';
    }


    // -----------------------------------------------------
    // FECHAR MENU MOBILE
    // -----------------------------------------------------

    function closeMobileMenu() {

        if (!mobileMenu) return;

        // Fechar o slide
        mobileMenu.classList.add(
            'translate-x-full',
            'opacity-0'
        );

        mobileMenu.classList.remove(
            'translate-x-0',
            'opacity-100'
        );

        // Mostrar novamente o hambúrguer
        if (heroMenuBtn) {
            heroMenuBtn.classList.remove('hidden');
        }

        // Liberar scroll
        document.body.style.overflow = '';
    }


    // -----------------------------------------------------
    // BOTÃO HAMBÚRGUER
    // -----------------------------------------------------

    if (heroMenuBtn) {
        heroMenuBtn.addEventListener(
            'click',
            openMobileMenu
        );
    }


    // -----------------------------------------------------
    // BOTÃO DO STICKY HEADER
    // -----------------------------------------------------

    if (stickyMenuBtn) {
        stickyMenuBtn.addEventListener(
            'click',
            openMobileMenu
        );
    }


    // -----------------------------------------------------
    // BOTÃO X / FECHAR
    // -----------------------------------------------------

    if (closeMobile) {
        closeMobile.addEventListener(
            'click',
            closeMobileMenu
        );
    }


    // =====================================================
    // ASIDE LATERAL DESKTOP
    // =====================================================

    const asideBtn = document.getElementById('aside-menu-btn');
    const asideBtn2 = document.getElementById('aside-menu-btn-2');

    const aside = document.getElementById('desktop-aside');
    const overlay = document.getElementById('desktop-overlay');

    const closeAside = document.getElementById('close-aside');


    // -----------------------------------------------------
    // ABRIR ASIDE
    // -----------------------------------------------------

    function openAside() {

        if (aside) {
            aside.classList.remove(
                'translate-x-full'
            );
        }

        if (overlay) {

            overlay.classList.remove(
                'opacity-0',
                'invisible'
            );

            overlay.classList.add(
                'opacity-100',
                'visible'
            );
        }

        // Bloquear scroll
        document.body.style.overflow = 'hidden';
    }


    // -----------------------------------------------------
    // FECHAR ASIDE
    // -----------------------------------------------------

    function closeAsideMenu() {

        if (aside) {
            aside.classList.add(
                'translate-x-full'
            );
        }

        if (overlay) {

            overlay.classList.add(
                'opacity-0',
                'invisible'
            );

            overlay.classList.remove(
                'opacity-100',
                'visible'
            );
        }

        // Liberar scroll
        document.body.style.overflow = '';
    }


    // -----------------------------------------------------
    // BOTÃO ASIDE PRINCIPAL
    // -----------------------------------------------------

    if (asideBtn) {
        asideBtn.addEventListener(
            'click',
            openAside
        );
    }


    // -----------------------------------------------------
    // BOTÃO ASIDE 2
    // -----------------------------------------------------

    if (asideBtn2) {
        asideBtn2.addEventListener(
            'click',
            openAside
        );
    }


    // -----------------------------------------------------
    // FECHAR ASIDE
    // -----------------------------------------------------

    if (closeAside) {
        closeAside.addEventListener(
            'click',
            closeAsideMenu
        );
    }


    // -----------------------------------------------------
    // FECHAR AO CLICAR NO OVERLAY
    // -----------------------------------------------------

    if (overlay) {
        overlay.addEventListener(
            'click',
            closeAsideMenu
        );
    }

})();
</script>