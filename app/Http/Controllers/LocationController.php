<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $countries = Country::withCount('cities')
            ->with(['cities' => fn($q) => $q->orderBy('name')])
            ->orderBy('name')
            ->get();

        $stats = [
            'total_countries' => $countries->count(),
            'total_cities'    => City::count(),
        ];

        return view('admin.locations.index', compact('countries', 'stats'));
    }

    public function storeCountry(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:countries,name',
            'code' => 'nullable|string|max:10',
        ]);

        Country::create([
            'name' => trim($request->name),
            'code' => $request->filled('code') ? strtoupper(trim($request->code)) : null,
            'is_active' => true,
        ]);

        return back()->with('success', 'País adicionado com sucesso!');
    }

    public function updateCountry(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:countries,name,' . $country->id,
            'code' => 'nullable|string|max:10',
        ]);

        $country->update([
            'name' => trim($request->name),
            'code' => $request->filled('code') ? strtoupper(trim($request->code)) : null,
        ]);

        return back()->with('success', 'País atualizado com sucesso!');
    }

    public function destroyCountry(Country $country)
    {
        $country->delete();
        return back()->with('success', 'País e suas cidades foram removidos com sucesso!');
    }

    public function storeCity(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name'       => 'required|string|max:100',
        ]);

        $country = Country::findOrFail($request->country_id);

        $exists = City::where('country_id', $country->id)
            ->whereRaw('LOWER(name) = ?', [strtolower(trim($request->name))])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Esta cidade já está cadastrada para este país.');
        }

        City::create([
            'country_id' => $country->id,
            'name'       => trim($request->name),
            'is_active'  => true,
        ]);

        return back()->with('success', 'Cidade adicionada com sucesso!');
    }

    public function updateCity(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $city->update([
            'name' => trim($request->name),
        ]);

        return back()->with('success', 'Cidade atualizada com sucesso!');
    }

    public function destroyCity(City $city)
    {
        $city->delete();
        return back()->with('success', 'Cidade removida com sucesso!');
    }
}
