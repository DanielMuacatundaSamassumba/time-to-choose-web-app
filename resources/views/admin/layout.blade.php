<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Painel Admin' }} — Time To Choose</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/Logo_Time.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/Logo_Time.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/Logo_Time.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            DEFAULT: '#F97316',
                            light:   '#FBA968',
                            dark:    '#EA6C00',
                            50:      '#FFF3EC',
                            100:     '#FFE4CC',
                            500:     '#F97316',
                            600:     '#EA6C00',
                        },
                        admin: {
                            bg:        '#F5F5F5',
                            sidebar:   '#0F0F0F',
                            card:      '#FFFFFF',
                            border:    '#E5E5E5',
                            text:      '#1A1A1A',
                            muted:     '#6B6B6B',
                        }
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
    {{ $styles ?? '' }}
</head>
<body class="bg-admin-bg h-full" x-data="{ sidebarOpen: false }">

<!-- Mobile overlay -->
<div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
     class="fixed inset-0 bg-black/50 z-40 lg:hidden"
     x-transition:enter="transition-opacity duration-300"
     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity duration-300"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

<!-- Sidebar -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed top-0 left-0 h-full w-64 bg-admin-sidebar flex flex-col z-50 transition-transform duration-300">

    <!-- Logo -->
    <div class="flex items-center gap-3 px-6 py-6 border-b border-white/10">
        <img src="{{ asset('assets/Logo_Time.png') }}" alt="Logo" class="h-8 brightness-0 invert">
      
    </div>

    <!-- Nav -->
    <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
        <p class="text-[10px] font-semibold text-gray-600 uppercase tracking-widest px-4 mb-3">Principal</p>

        @php
            $linkClass = "flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium border border-transparent transition-all duration-200 ";
            $activeLinkClass = "text-white bg-brand/20 border-brand/30 ";
            $inactiveLinkClass = "text-gray-400 hover:text-white hover:bg-white/10 ";
        @endphp

        <a href="{{ route('admin.dashboard') }}"
           class="{{ $linkClass }} {{ request()->routeIs('admin.dashboard') ? $activeLinkClass : $inactiveLinkClass }}">
            <i class="fa-solid fa-gauge-high w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-brand' : '' }}"></i>
            Dashboard
        </a>

        <a href="{{ route('admin.properties.index') }}"
           class="{{ $linkClass }} {{ request()->routeIs('admin.properties.*') ? $activeLinkClass : $inactiveLinkClass }}">
            <i class="fa-solid fa-building w-5 text-center {{ request()->routeIs('admin.properties.*') ? 'text-brand' : '' }}"></i>
            Imóveis
            @php $totalProps = \App\Models\Property::count(); @endphp
            <span class="ml-auto bg-brand/20 text-brand text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $totalProps }}</span>
        </a>

        <a href="{{ route('admin.messages.index') }}"
           class="{{ $linkClass }} {{ request()->routeIs('admin.messages.*') ? $activeLinkClass : $inactiveLinkClass }}">
            <i class="fa-solid fa-envelope w-5 text-center {{ request()->routeIs('admin.messages.*') ? 'text-brand' : '' }}"></i>
            Mensagens
            @php $unread = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
            @if($unread > 0)
            <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $unread }}</span>
            @endif
        </a>

        <a href="{{ route('admin.content.index') }}"
           class="{{ $linkClass }} {{ request()->routeIs('admin.content.*') ? $activeLinkClass : $inactiveLinkClass }}">
            <i class="fa-solid fa-file-pen w-5 text-center {{ request()->routeIs('admin.content.*') ? 'text-brand' : '' }}"></i>
            Páginas & Conteúdo
        </a>

        <div class="pt-4 pb-2">
            <p class="text-[10px] font-semibold text-gray-600 uppercase tracking-widest px-4 mb-3">Sistema</p>
        </div>

        <a href="{{ route('admin.media.index') }}"
           class="{{ $linkClass }} {{ request()->routeIs('admin.media.*') ? $activeLinkClass : $inactiveLinkClass }}">
            <i class="fa-solid fa-images w-5 text-center {{ request()->routeIs('admin.media.*') ? 'text-brand' : '' }}"></i>
            Biblioteca de Media
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="{{ $linkClass }} {{ request()->routeIs('admin.users.*') ? $activeLinkClass : $inactiveLinkClass }}">
            <i class="fa-solid fa-users-gear w-5 text-center {{ request()->routeIs('admin.users.*') ? 'text-brand' : '' }}"></i>
            Utilizadores
        </a>

        <a href="{{ route('admin.settings.index') }}"
           class="{{ $linkClass }} {{ request()->routeIs('admin.settings.*') ? $activeLinkClass : $inactiveLinkClass }}">
            <i class="fa-solid fa-sliders w-5 text-center {{ request()->routeIs('admin.settings.*') ? 'text-brand' : '' }}"></i>
            Configurações
        </a>

        <div class="pt-4 pb-2">
            <p class="text-[10px] font-semibold text-gray-600 uppercase tracking-widest px-4 mb-3">Site</p>
        </div>

        <a href="{{ url('/') }}" target="_blank"
           class="{{ $linkClass }} {{ $inactiveLinkClass }}">
            <i class="fa-solid fa-arrow-up-right-from-square w-5 text-center"></i>
            Ver Site
        </a>
    </nav>

    <!-- User -->
    <div class="px-3 py-4 border-t border-white/10">
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/5">
            <div class="w-8 h-8 rounded-full bg-brand flex items-center justify-center text-white text-xs font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white text-xs font-semibold truncate">{{ auth()->user()->name }}</p>
                <p class="text-gray-500 text-[10px] truncate">{{ auth()->user()->email }}</p>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" title="Sair" class="text-gray-500 hover:text-red-400 transition">
                    <i class="fa-solid fa-right-from-bracket text-sm"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Main content -->
<div class="lg:pl-64 flex flex-col min-h-screen">
    <!-- Top bar -->
    <header class="bg-white border-b border-admin-border px-6 py-4 flex items-center gap-4 sticky top-0 z-30">
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-800">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>
        <div class="flex-1">
            <h1 class="text-lg font-bold text-admin-text">{{ $title ?? 'Dashboard' }}</h1>
            @isset($breadcrumb)
            <p class="text-xs text-admin-muted">{{ $breadcrumb }}</p>
            @endisset
        </div>
        <div class="flex items-center gap-3">
            @php $unreadTop = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
            @if($unreadTop > 0)
            <a href="{{ route('admin.messages.index') }}" class="relative p-2 text-gray-500 hover:text-brand transition">
                <i class="fa-solid fa-bell text-lg"></i>
                <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">{{ $unreadTop }}</span>
            </a>
            @endif
            <a href="{{ route('admin.properties.create') }}"
               class="bg-brand hover:bg-brand-dark text-white text-sm font-semibold px-4 py-2 rounded-xl flex items-center gap-2 transition">
                <i class="fa-solid fa-plus"></i>
                Novo Imóvel
            </a>
        </div>
    </header>

    <!-- Page content -->
    <main class="flex-1 p-6">
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
            <button @click="show = false" class="ml-auto text-green-500 hover:text-green-700">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @endif

        {{ $slot }}
    </main>
</div>

@stack('scripts')
</body>
</html>
