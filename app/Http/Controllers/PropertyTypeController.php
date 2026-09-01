<?php

namespace App\Http\Controllers;

use App\Models\PropertyType;
use App\Models\LandType;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyTypeController extends Controller
{
    public function index()
    {
        $types = PropertyType::orderBy('order')
            ->orderBy('name')
            ->get()
            ->map(function ($type) {
                $type->properties_count = Property::where('property_type', $type->slug)
                    ->orWhere('property_type', $type->name)
                    ->count();
                return $type;
            });

        $landTypes = LandType::orderBy('order')
            ->orderBy('name')
            ->get()
            ->map(function ($lt) {
                $lt->properties_count = Property::where('land_type', $lt->slug)
                    ->orWhere('land_type', $lt->name)
                    ->count();
                return $lt;
            });

        $stats = [
            'total_types'      => $types->count(),
            'active_types'     => $types->where('is_active', true)->count(),
            'total_land_types' => $landTypes->count(),
        ];

        return view('admin.property_types.index', compact('types', 'landTypes', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'slug'   => 'nullable|string|max:100|unique:property_types,slug',
            'nature' => 'required|in:residential,area_based',
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);

        // Se slug gerado já existir, cria com sufixo
        $originalSlug = $slug;
        $count = 1;
        while (PropertyType::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $maxOrder = PropertyType::max('order') ?? 0;

        PropertyType::create([
            'name'      => trim($request->name),
            'slug'      => $slug,
            'nature'    => $request->nature,
            'order'     => $maxOrder + 1,
            'is_active' => true,
        ]);

        return back()->with('success', 'Tipo de imóvel adicionado com sucesso!');
    }

    public function update(Request $request, PropertyType $propertyType)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'slug'   => 'nullable|string|max:100|unique:property_types,slug,' . $propertyType->id,
            'nature' => 'required|in:residential,area_based',
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);

        $propertyType->update([
            'name'   => trim($request->name),
            'slug'   => $slug,
            'nature' => $request->nature,
        ]);

        return back()->with('success', 'Tipo de imóvel atualizado com sucesso!');
    }

    public function destroy(PropertyType $propertyType)
    {
        $linkedProperties = Property::where('property_type', $propertyType->slug)->count();
        if ($linkedProperties > 0) {
            return back()->with('error', "Não é possível eliminar: existem {$linkedProperties} imóveis associados a este tipo.");
        }

        $propertyType->delete();
        return back()->with('success', 'Tipo de imóvel removido com sucesso!');
    }
}
