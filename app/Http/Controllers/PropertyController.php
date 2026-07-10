<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::where('is_active', true);

        // Full-text search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        // Typology filter — context-aware by property_type
        if ($request->filled('typology')) {
            $typology = $request->typology;
            $propType = strtolower($request->input('property_type', ''));

            $isAreaBased = in_array($propType, ['terreno', 'escritório', 'escritorio', 'loja']);

            if ($isAreaBased) {
                // Area-based filter for land and commercial (filter stores numeric m² ceiling)
                $areaVal = preg_replace('/\D/', '', $typology);
                if (is_numeric($areaVal)) {
                    // area column is like "800 m²" — extract numeric part via CAST
                    $query->whereRaw("CAST(area AS INTEGER) <= ?", [$areaVal]);
                }
            } else {
                // Bedroom-based filter — strip T/V prefix, handle 6+
                if (str_ends_with($typology, '+')) {
                    $num = (int) rtrim($typology, '+');
                    $query->where('bedrooms', '>=', $num);
                } else {
                    $num = preg_replace('/\D/', '', $typology); // 'T3' → '3', 'V4' → '4', '2' → '2'
                    if (is_numeric($num)) {
                        $query->where('bedrooms', (int) $num);
                    }
                }
            }
        }

        // Sorting
        $sort = $request->input('sort', 'recentes');
        match ($sort) {
            'preco_baixo' => $query->orderBy('price', 'asc'),
            'preco_alto'  => $query->orderBy('price', 'desc'),
            default       => $query->latest(),
        };

        // For dynamic filter options
        $countries = Property::where('is_active', true)->distinct()->pluck('country')->sort()->values();
        $cities    = Property::where('is_active', true)
            ->when($request->filled('country'), fn($q) => $q->where('country', $request->country))
            ->distinct()->pluck('city')->sort()->values();

        $properties = $query->paginate(9)->withQueryString();

        return view('pages.imoveis', compact('properties', 'countries', 'cities'));
    }

    public function show(Property $property)
    {
        abort_if(!$property->is_active, 404);
        $related = Property::where('is_active', true)
            ->where('id', '!=', $property->id)
            ->where('property_type', $property->property_type)
            ->take(3)
            ->get();
        return view('pages.personal-imovel', compact('property', 'related'));
    }
}
