<x-admin.layout title="Mensagens" breadcrumb="Caixa de entrada de clientes">

    <div class="bg-white rounded-2xl border border-admin-border overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5 border-b border-admin-border">
            <div>
                <h2 class="font-bold text-admin-text">Caixa de Entrada</h2>
                <p class="text-xs text-admin-muted mt-0.5">{{ $messages->total() }} mensagens no total</p>
            </div>
        </div>

        <div class="divide-y divide-admin-border">
            @forelse($messages as $msg)
            <div class="flex items-start gap-5 px-6 py-5 hover:bg-gray-50 transition group {{ !$msg->is_read ? 'bg-brand/5 border-l-4 border-l-brand' : '' }}">
                <!-- Avatar -->
                <div class="w-11 h-11 rounded-full bg-brand flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr($msg->name, 0, 1)) }}
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="font-bold text-sm text-admin-text">{{ $msg->name }}
                                @if(!$msg->is_read)
                                <span class="ml-2 text-[10px] font-semibold text-brand bg-brand/10 px-2 py-0.5 rounded-full">NOVO</span>
                                @endif
                            </p>
                            <div class="flex items-center gap-3 mt-0.5">
                                <a href="mailto:{{ $msg->email }}" class="text-xs text-admin-muted hover:text-brand transition">
                                    <i class="fa-solid fa-envelope mr-1"></i>{{ $msg->email }}
                                </a>
                                @if($msg->phone)
                                <a href="tel:{{ $msg->phone }}" class="text-xs text-admin-muted hover:text-brand transition">
                                    <i class="fa-solid fa-phone mr-1"></i>{{ $msg->phone }}
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <span class="text-xs text-admin-muted whitespace-nowrap">{{ $msg->created_at->format('d/m/Y H:i') }}</span>
                            <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST"
                                  onsubmit="return confirm('Eliminar esta mensagem?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="opacity-0 group-hover:opacity-100 p-1.5 text-gray-300 hover:text-red-400 hover:bg-red-50 rounded-lg transition">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <p class="text-sm text-admin-muted mt-2 leading-relaxed">{{ $msg->message }}</p>

                    @if($msg->property)
                    <div class="mt-3 inline-flex items-center gap-2 bg-brand/10 text-brand text-xs font-medium px-3 py-1.5 rounded-lg">
                        <i class="fa-solid fa-building text-[10px]"></i>
                        Imóvel: {{ $msg->property->title }}
                        <a href="{{ route('admin.properties.edit', $msg->property) }}" class="underline hover:no-underline">Editar</a>
                    </div>
                    @endif

                    <!-- Quick reply -->
                    <div class="mt-3 flex items-center gap-3">
                        <a href="mailto:{{ $msg->email }}?subject=Re: Contacto Time To Choose"
                           class="text-xs font-medium text-brand hover:underline flex items-center gap-1.5">
                            <i class="fa-solid fa-reply"></i>
                            Responder por email
                        </a>
                        @if($msg->phone)
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $msg->phone) }}" target="_blank"
                           class="text-xs font-medium text-green-600 hover:underline flex items-center gap-1.5">
                            <i class="fa-brands fa-whatsapp"></i>
                            WhatsApp
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="py-20 text-center text-admin-muted">
                <i class="fa-solid fa-envelope-open text-5xl mb-4 opacity-20 block"></i>
                <p class="text-sm font-medium">Nenhuma mensagem recebida ainda.</p>
                <p class="text-xs mt-1">As mensagens enviadas pelos clientes aparecerão aqui.</p>
            </div>
            @endforelse
        </div>

        @if($messages->hasPages())
        <div class="px-6 py-4 border-t border-admin-border">
            {{ $messages->links() }}
        </div>
        @endif
    </div>

</x-admin.layout>
