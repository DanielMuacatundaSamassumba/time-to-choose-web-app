@props(['transparent' => false, 'dropUp' => false])

<div class="relative notranslate inline-block" x-data="{
    open: false,
    currentLang: localStorage.getItem('site_lang') || 'pt',
    changeLang(lang) {
        this.currentLang = lang;
        let googLang = 'pt';
        if (lang === 'en') googLang = 'en';
        if (lang === 'fr') googLang = 'fr';
        if (lang === 'zh') googLang = 'zh-CN';

        localStorage.setItem('site_lang', lang);

        let host = window.location.hostname;
        document.cookie = 'googtrans=/pt/' + googLang + '; path=/;';
        document.cookie = 'googtrans=/pt/' + googLang + '; domain=' + host + '; path=/;';

        const select = document.querySelector('.goog-te-combo');
        if (select) {
            select.value = googLang;
            select.dispatchEvent(new Event('change'));
        }

        window.location.reload();
    }
}">
    {{-- Trigger button --}}
    <button @click="open = !open" type="button"
        class="flex items-center gap-2 px-3 py-1.5 rounded-sm text-xs font-bold uppercase transition border shadow-sm {{ $transparent ? 'border-white/30 text-white hover:bg-white/20' : 'border-gray-200 text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300' }}">
        <span class="flex items-center gap-1.5">
            <template x-if="currentLang === 'pt'">
                <span class="flex items-center gap-1.5"><span class="text-sm">🇵🇹</span> PT</span>
            </template>
            <template x-if="currentLang === 'en'">
                <span class="flex items-center gap-1.5"><span class="text-sm">🇬🇧</span> EN</span>
            </template>
            <template x-if="currentLang === 'fr'">
                <span class="flex items-center gap-1.5"><span class="text-sm">🇫🇷</span> FR</span>
            </template>
            <template x-if="currentLang === 'zh'">
                <span class="flex items-center gap-1.5"><span class="text-sm">🇨🇳</span> ZH</span>
            </template>
        </span>
        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
    </button>

    {{-- Dropdown Menu --}}
    <div x-show="open" @click.outside="open = false" x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 {{ $dropUp ? 'bottom-full mb-2' : 'top-full mt-2' }} w-44 bg-white rounded-sm shadow-2xl border border-gray-100 py-2 z-[99999] text-gray-800 text-xs font-semibold overflow-hidden">
        
        <p class="px-4 py-1 text-[10px] font-bold uppercase tracking-wider text-gray-400 border-b border-gray-100 mb-1">
            Idioma / Language
        </p>

        <button type="button" @click="changeLang('pt'); open = false"
            class="w-full px-4 py-2.5 text-left flex items-center justify-between transition hover:bg-[#F97316]/10 hover:text-[#F97316] {{ request()->get('lang') === 'pt' ? 'bg-[#F97316]/5 text-[#F97316]' : '' }}">
            <span class="flex items-center gap-2.5">
                <span class="text-base">🇵🇹</span>
                <span>Português</span>
            </span>
            <template x-if="currentLang === 'pt'">
                <i class="fa-solid fa-check text-[#F97316] text-xs"></i>
            </template>
        </button>

        <button type="button" @click="changeLang('en'); open = false"
            class="w-full px-4 py-2.5 text-left flex items-center justify-between transition hover:bg-[#F97316]/10 hover:text-[#F97316]">
            <span class="flex items-center gap-2.5">
                <span class="text-base">🇬🇧</span>
                <span>English</span>
            </span>
            <template x-if="currentLang === 'en'">
                <i class="fa-solid fa-check text-[#F97316] text-xs"></i>
            </template>
        </button>

        <button type="button" @click="changeLang('fr'); open = false"
            class="w-full px-4 py-2.5 text-left flex items-center justify-between transition hover:bg-[#F97316]/10 hover:text-[#F97316]">
            <span class="flex items-center gap-2.5">
                <span class="text-base">🇫🇷</span>
                <span>Français</span>
            </span>
            <template x-if="currentLang === 'fr'">
                <i class="fa-solid fa-check text-[#F97316] text-xs"></i>
            </template>
        </button>

        <button type="button" @click="changeLang('zh'); open = false"
            class="w-full px-4 py-2.5 text-left flex items-center justify-between transition hover:bg-[#F97316]/10 hover:text-[#F97316]">
            <span class="flex items-center gap-2.5">
                <span class="text-base">🇨🇳</span>
                <span>中文 (Mandarim)</span>
            </span>
            <template x-if="currentLang === 'zh'">
                <i class="fa-solid fa-check text-[#F97316] text-xs"></i>
            </template>
        </button>
    </div>
</div>
