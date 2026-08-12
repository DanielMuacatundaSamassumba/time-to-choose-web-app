<x-admin.layout title="Utilizadores" breadcrumb="Gestão de Administradores">

    <!-- Actions & Filter bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center gap-3 flex-1 max-w-md">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Pesquisar por nome ou e-mail..."
                       class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition">
            </div>
            <button type="submit" class="bg-brand hover:bg-brand-dark text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
                Filtrar
            </button>
        </form>

        <a href="{{ route('admin.users.create') }}"
           class="bg-brand hover:bg-brand-dark text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-user-plus text-xs"></i>
            Novo Administrador
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-admin-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-admin-border bg-gray-50/50 text-[11px] font-bold uppercase tracking-wider text-admin-muted">
                        <th class="px-6 py-4">Utilizador</th>
                        <th class="px-6 py-4">E-mail</th>
                        <th class="px-6 py-4">Data de Registo</th>
                        <th class="px-6 py-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border text-sm">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-brand/10 text-brand font-bold flex items-center justify-center text-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-admin-text">{{ $user->name }}</p>
                                    @if($user->id === auth()->id())
                                        <span class="text-[10px] bg-green-100 text-green-700 font-bold px-2 py-0.5 rounded-full">Sessão Atual</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-admin-muted font-medium">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 text-admin-muted text-xs">
                            {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="p-2 text-gray-400 hover:text-brand transition rounded-lg hover:bg-gray-100" title="Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Tem a certeza que deseja eliminar este utilizador?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition rounded-lg hover:bg-gray-100" title="Eliminar">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-admin-muted">
                            Nenhum utilizador encontrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-admin-border">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</x-admin.layout>
