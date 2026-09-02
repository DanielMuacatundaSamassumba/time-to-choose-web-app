<x-admin.layout title="Editar Administrador" breadcrumb="Utilizadores / Editar">

    <div class="max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="text-sm text-admin-muted hover:text-admin-text transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left text-xs"></i> Voltar à lista de utilizadores
            </a>
        </div>

        <div class="bg-white rounded-sm border border-admin-border p-6">
            <h2 class="font-bold text-admin-text mb-6 text-lg flex items-center gap-2">
                <i class="fa-solid fa-user-pen text-brand"></i>
                Editar Administrador: {{ $user->name }}
            </h2>

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                @php
                    $labelClass = "block text-xs font-semibold text-admin-muted uppercase tracking-wider mb-2";
                    $inputClass = "w-full border border-gray-200 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition";
                @endphp

                <div class="space-y-5">
                    <div>
                        <label class="{{ $labelClass }}">Nome Completo <span class="text-red-400">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="{{ $inputClass }}">
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Endereço de E-mail <span class="text-red-400">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="{{ $inputClass }}">
                        @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <label class="{{ $labelClass }}">Nova Palavra-passe <span class="text-gray-400 font-normal">(Deixar em branco para manter a atual)</span></label>
                        <input type="password" name="password" class="{{ $inputClass }}" placeholder="Preencher apenas se desejar alterar">
                        @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Confirmar Nova Palavra-passe</label>
                        <input type="password" name="password_confirmation" class="{{ $inputClass }}" placeholder="Repita a nova palavra-passe">
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 text-sm font-semibold text-admin-muted hover:text-admin-text border border-admin-border rounded-sm transition">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-brand hover:bg-brand-dark text-white text-sm font-semibold px-6 py-2.5 rounded-sm transition flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-admin.layout>
