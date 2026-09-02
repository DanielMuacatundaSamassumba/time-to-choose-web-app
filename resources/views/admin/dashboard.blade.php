<x-admin.layout title="Dashboard" breadcrumb="Visão geral da plataforma">

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Imóveis -->
        <div class="bg-white rounded-sm p-6 border border-admin-border hover:shadow-md transition">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-sm bg-brand/10 flex items-center justify-center">
                    <i class="fa-solid fa-building text-brand text-lg"></i>
                </div>
                <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full font-medium">Total</span>
            </div>
            <p class="text-3xl font-bold text-admin-text">{{ $stats['total_properties'] }}</p>
            <p class="text-sm text-admin-muted mt-1">Imóveis cadastrados</p>
        </div>

        <!-- Ativos -->
        <div class="bg-white rounded-sm p-6 border border-admin-border hover:shadow-md transition">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-sm bg-green-50 flex items-center justify-center">
                    <i class="fa-solid fa-circle-check text-green-500 text-lg"></i>
                </div>
                <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full font-medium">Ativos</span>
            </div>
            <p class="text-3xl font-bold text-admin-text">{{ $stats['active_properties'] }}</p>
            <p class="text-sm text-admin-muted mt-1">Disponíveis no site</p>
        </div>

        <!-- Em Destaque -->
        <div class="bg-white rounded-sm p-6 border border-admin-border hover:shadow-md transition">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-sm bg-yellow-50 flex items-center justify-center">
                    <i class="fa-solid fa-star text-yellow-500 text-lg"></i>
                </div>
                <span class="text-xs text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full font-medium">Destaque</span>
            </div>
            <p class="text-3xl font-bold text-admin-text">{{ $stats['featured'] }}</p>
            <p class="text-sm text-admin-muted mt-1">Em destaque na homepage</p>
        </div>

        <!-- Novas Mensagens -->
        <div class="bg-white rounded-sm p-6 border border-admin-border hover:shadow-md transition">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-sm bg-red-50 flex items-center justify-center">
                    <i class="fa-solid fa-envelope text-red-400 text-lg"></i>
                </div>
                <span class="text-xs text-red-600 bg-red-50 px-2 py-1 rounded-full font-medium">Não lidas</span>
            </div>
            <p class="text-3xl font-bold text-admin-text">{{ $stats['new_messages'] }}</p>
            <p class="text-sm text-admin-muted mt-1">Mensagens de clientes</p>
        </div>
    </div>

    <!-- Main content grid -->
    <div class="grid lg:grid-cols-3 gap-6">

        <!-- Recent Properties -->
        <div class="lg:col-span-2 bg-white rounded-sm border border-admin-border">
            <div class="flex items-center justify-between px-6 py-5 border-b border-admin-border">
                <h2 class="font-bold text-admin-text">Imóveis Recentes</h2>
                <a href="{{ route('admin.properties.index') }}" class="text-brand text-sm font-medium hover:underline">
                    Ver todos →
                </a>
            </div>
            <div class="divide-y divide-admin-border">
                @forelse($recentProperties as $property)
                <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition">
                    <!-- Thumbnail -->
                    <div class="w-14 h-14 rounded-sm overflow-hidden flex-shrink-0 bg-gray-100">
                        @if($property->image && file_exists(public_path('assets/' . $property->image)))
                            <img src="{{ asset('assets/' . $property->image) }}" alt="{{ $property->title }}" class="w-full h-full object-cover">
                        @elseif($property->image && Str::startsWith($property->image, 'properties/'))
                            <img src="{{ Storage::url($property->image) }}" alt="{{ $property->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-brand/10 flex items-center justify-center">
                                <i class="fa-solid fa-building text-brand"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm text-admin-text truncate">{{ $property->title }}</p>
                        <p class="text-xs text-admin-muted mt-0.5">
                            <i class="fa-solid fa-location-dot mr-1"></i>{{ $property->location }}
                        </p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-sm font-bold text-brand">{{ $property->price }}</p>
                        <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold {{ $property->status_badge['class'] }}">
                            {{ $property->status_badge['label'] }}
                        </span>
                    </div>
                    <div class="flex gap-1">
                        <a href="{{ route('admin.properties.edit', $property) }}"
                           class="p-2 text-gray-400 hover:text-brand hover:bg-brand/10 rounded-sm transition">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="px-6 py-12 text-center text-admin-muted">
                    <i class="fa-solid fa-building text-3xl mb-3 opacity-30"></i>
                    <p class="text-sm">Nenhum imóvel cadastrado ainda.</p>
                    <a href="{{ route('admin.properties.create') }}" class="text-brand text-sm font-medium hover:underline mt-2 inline-block">
                        Criar o primeiro imóvel →
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Messages -->
        <div class="bg-white rounded-sm border border-admin-border">
            <div class="flex items-center justify-between px-6 py-5 border-b border-admin-border">
                <h2 class="font-bold text-admin-text">Mensagens Recentes</h2>
                <a href="{{ route('admin.messages.index') }}" class="text-brand text-sm font-medium hover:underline">
                    Ver todas →
                </a>
            </div>
            <div class="divide-y divide-admin-border">
                @forelse($recentMessages as $msg)
                <div class="px-6 py-4 hover:bg-gray-50 transition {{ !$msg->is_read ? 'bg-brand/5' : '' }}">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-full bg-brand flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                            {{ strtoupper(substr($msg->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-admin-text truncate">{{ $msg->name }}</p>
                            <p class="text-[10px] text-admin-muted">{{ $msg->created_at->diffForHumans() }}</p>
                        </div>
                        @if(!$msg->is_read)
                            <span class="w-2 h-2 bg-brand rounded-full flex-shrink-0"></span>
                        @endif
                    </div>
                    <p class="text-xs text-admin-muted line-clamp-2 pl-11">{{ $msg->message }}</p>
                    @if($msg->property)
                    <p class="text-[10px] text-brand pl-11 mt-1">
                        <i class="fa-solid fa-building mr-1"></i>{{ $msg->property->title }}
                    </p>
                    @endif
                </div>
                @empty
                <div class="px-6 py-12 text-center text-admin-muted">
                    <i class="fa-solid fa-envelope text-3xl mb-3 opacity-30"></i>
                    <p class="text-sm">Nenhuma mensagem recebida.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('admin.properties.create') }}"
           class="group bg-white border border-admin-border hover:border-brand hover:bg-brand/5 rounded-sm p-5 flex items-center gap-4 transition">
            <div class="w-10 h-10 rounded-sm bg-brand group-hover:bg-brand text-white flex items-center justify-center transition">
                <i class="fa-solid fa-plus text-sm"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-admin-text">Novo Imóvel</p>
                <p class="text-xs text-admin-muted">Adicionar propriedade</p>
            </div>
        </a>
        <a href="{{ route('admin.messages.index') }}"
           class="group bg-white border border-admin-border hover:border-brand hover:bg-brand/5 rounded-sm p-5 flex items-center gap-4 transition">
            <div class="w-10 h-10 rounded-sm bg-gray-100 group-hover:bg-brand text-gray-500 group-hover:text-white flex items-center justify-center transition">
                <i class="fa-solid fa-inbox text-sm"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-admin-text">Mensagens</p>
                <p class="text-xs text-admin-muted">{{ $stats['total_messages'] }} no total</p>
            </div>
        </a>
        <a href="{{ url('/imoveis') }}" target="_blank"
           class="group bg-white border border-admin-border hover:border-brand hover:bg-brand/5 rounded-sm p-5 flex items-center gap-4 transition">
            <div class="w-10 h-10 rounded-sm bg-gray-100 group-hover:bg-brand text-gray-500 group-hover:text-white flex items-center justify-center transition">
                <i class="fa-solid fa-eye text-sm"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-admin-text">Ver Imóveis</p>
                <p class="text-xs text-admin-muted">Página pública</p>
            </div>
        </a>
        <a href="{{ url('/') }}" target="_blank"
           class="group bg-white border border-admin-border hover:border-brand hover:bg-brand/5 rounded-sm p-5 flex items-center gap-4 transition">
            <div class="w-10 h-10 rounded-sm bg-gray-100 group-hover:bg-brand text-gray-500 group-hover:text-white flex items-center justify-center transition">
                <i class="fa-solid fa-house text-sm"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-admin-text">Homepage</p>
                <p class="text-xs text-admin-muted">Ver o site público</p>
            </div>
        </a>
    </div>

</x-admin.layout>
