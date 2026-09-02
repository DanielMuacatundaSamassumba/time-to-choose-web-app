<x-admin.layout title="Editar Imóvel" breadcrumb="Imóveis → Editar">

    <div class="">
        <form id="update-property-form" action="{{ route('admin.properties.update', $property) }}" method="POST" enctype="multipart/form-data"
              x-data="propertyForm()" class="space-y-6">
            @csrf
            @method('PUT')

            @include('admin.properties._form', ['property' => $property])

            <div class="flex items-center gap-4 pt-4">
                <button type="submit"
                        class="bg-brand hover:bg-brand-dark text-white font-bold px-8 py-3 rounded-sm flex items-center gap-2 transition">
                    <i class="fa-solid fa-check"></i>
                    Actualizar Imóvel
                </button>
                <a href="{{ route('admin.properties.index') }}" class="text-admin-muted hover:text-admin-text text-sm transition">
                    Cancelar
                </a>
                
                <button type="submit" form="delete-property-form" class="text-red-400 hover:text-red-600 text-sm flex items-center gap-2 transition ml-auto">
                    <i class="fa-solid fa-trash"></i>
                    Eliminar
                </button>
            </div>
        </form>

        <form id="delete-property-form" action="{{ route('admin.properties.destroy', $property) }}" method="POST"
              class="hidden" onsubmit="return confirm('Eliminar este imóvel?')">
            @csrf
            @method('DELETE')
        </form>
    </div>

</x-admin.layout>
