<x-admin.layout title="Novo Imóvel" breadcrumb="Imóveis → Criar">

    <div class="">
        <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data"
              x-data="propertyForm()" class="space-y-6">
            @csrf

            @include('admin.properties._form', ['property' => null])

            <div class="flex items-center gap-4 pt-4">
                <button type="submit"
                        class="bg-brand hover:bg-brand-dark text-white font-bold px-8 py-3 rounded-sm flex items-center gap-2 transition">
                    <i class="fa-solid fa-check"></i>
                    Guardar Imóvel
                </button>
                <a href="{{ route('admin.properties.index') }}" class="text-admin-muted hover:text-admin-text text-sm transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

</x-admin.layout>
