<?php

namespace App\Http\Controllers;

use App\Models\LandType;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LandTypeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'slug'        => 'nullable|string|max:100|unique:land_types,slug',
            'description' => 'nullable|string|max:255',
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);

        $originalSlug = $slug;
        $count = 1;
        while (LandType::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $maxOrder = LandType::max('order') ?? 0;

        LandType::create([
            'name'        => trim($request->name),
            'slug'        => $slug,
            'description' => $request->description,
            'order'       => $maxOrder + 1,
            'is_active'   => true,
        ]);

        return back()->with('success', 'Classificação de terreno adicionada com sucesso!');
    }

    public function update(Request $request, LandType $landType)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'slug'        => 'nullable|string|max:100|unique:land_types,slug,' . $landType->id,
            'description' => 'nullable|string|max:255',
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);

        $landType->update([
            'name'        => trim($request->name),
            'slug'        => $slug,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Classificação de terreno atualizada com sucesso!');
    }

    public function destroy(LandType $landType)
    {
        $linkedProperties = Property::where('land_type', $landType->slug)->count();
        if ($linkedProperties > 0) {
            return back()->with('error', "Não é possível eliminar: existem {$linkedProperties} terrenos associados a esta classificação.");
        }

        $landType->delete();
        return back()->with('success', 'Classificação de terreno removida com sucesso!');
    }
}
