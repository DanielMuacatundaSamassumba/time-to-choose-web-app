<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::where('is_active', true);

        // ── Full-text search ──────────────────────────────────────
        if ($request->filled('search')) {

            $search = $request->input('search');

            $cleanSearch = preg_replace('/[^[:alpha:]\s]/u', '', $search);

            if ($search !== $cleanSearch) {
                return back()->with('error', 'A pesquisa contém caracteres inválidos.');
            }

            $query->where(function ($q) use ($cleanSearch) {
                $q->where('title', 'like', "%{$cleanSearch}%")
                    ->orWhere('description', 'like', "%{$cleanSearch}%")
                    ->orWhere('location', 'like', "%{$cleanSearch}%")
                    ->orWhere('city', 'like', "%{$cleanSearch}%");
            });
        }

        // ── Category / type unified filter (matches menu slugs) ──────
        // category=venda           → type = 'venda'
        // category=arrendamento-*  → category field in DB
      if ($request->filled('category')) {
    $cat = $request->input('category');

    if ($cat === 'venda') {
        $query->where('type', 'venda');
    } elseif (in_array($cat, [
        'transpasse',
        'arrendamento-longa-duracao',
        'arrendamento-curta-duracao'
    ])) {
        $query->where('category', $cat);
    }
}

        // Legacy: direct type filter (kept for backward compat)
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('property_type')) {
            $pt = strtolower($request->input('property_type'));
            $query->where(function ($q) use ($pt) {
                if (in_array($pt, ['espaco-comercial', 'espacos-comerciais', 'espaços_comerciais', 'espacos-comercias'])) {
                    $q->where('property_type', 'like', '%comercia%')
                      ->orWhere('property_type', 'espaco-comercial');
                } elseif (in_array($pt, ['escritorio', 'escritório', 'escritorios'])) {
                    $q->where('property_type', 'like', '%escrit%');
                } elseif (in_array($pt, ['terreno', 'terrenos'])) {
                    $q->where('property_type', 'like', '%terren%');
                } elseif (in_array($pt, ['armazem', 'armazens', 'armazém'])) {
                    $q->where('property_type', 'like', '%armaz%');
                } elseif (in_array($pt, ['loja', 'lojas'])) {
                    $q->where('property_type', 'like', '%loja%');
                } elseif (in_array($pt, ['vivenda', 'vivendas'])) {
                    $q->where('property_type', 'like', '%vivend%');
                } elseif (in_array($pt, ['apartamento', 'apartamentos'])) {
                    $q->where('property_type', 'like', '%apart%');
                } elseif (in_array($pt, ['empreendimento', 'empreendimentos'])) {
                    $q->where('property_type', 'like', '%empreend%');
                } else {
                    $q->where('property_type', $pt);
                }
            });
        }

        if ($request->filled('country')) {
            $query->where('country', $request->input('country'));
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->input('city') . '%');
        }

        // ── Direct Land Type filter ──────────────────────────────
        if ($request->filled('land_type')) {
            $lt = strtolower(trim((string) $request->input('land_type')));
            $query->where(function ($q) use ($lt) {
                $q->where('land_type', $lt)
                  ->orWhere('land_type', 'like', "%{$lt}%")
                  ->orWhere('title', 'like', "%{$lt}%")
                  ->orWhere('description', 'like', "%{$lt}%");
            });
        }

        // ── Direct Area filter ────────────────────────────────────
        if ($request->filled('area')) {
            $areaVal = preg_replace('/\D/', '', (string) $request->input('area'));
            if (is_numeric($areaVal) && (int) $areaVal > 0) {
                $query->where(function ($q) use ($areaVal) {
                    $q->where('area', 'like', "%{$areaVal}%")
                      ->orWhereRaw("CAST(REPLACE(REPLACE(REPLACE(area, '.', ''), 'm²', ''), ' ', '') AS UNSIGNED) <= ?", [(int) $areaVal]);
                });
            }
        }

        // ── Typology filter — context-aware ───────────────────────
        if ($request->filled('typology')) {
            $typology = strtolower(trim((string) $request->input('typology')));
            $propType = strtolower(trim((string) $request->input('property_type')));

            // Classificação de Terrenos: Urbanos, Rústicos, Industriais, Projecto Aprovado
            if (in_array($typology, ['urbanos', 'rusticos', 'industriais', 'projecto-aprovado', 'urbano', 'rustico', 'industrial', 'projecto_aprovado'])) {
                $termMap = [
                    'urbanos'           => 'urban',
                    'rusticos'          => 'rústic',
                    'industriais'       => 'industri',
                    'projecto-aprovado' => 'projecto aprovado',
                ];
                $searchRoot = $termMap[$typology] ?? $typology;
                $query->where(function ($q) use ($searchRoot, $typology) {
                    $q->where('land_type', $typology)
                      ->orWhere('land_type', 'like', "%{$typology}%")
                      ->orWhere('title', 'like', "%{$searchRoot}%")
                      ->orWhere('description', 'like', "%{$searchRoot}%")
                      ->orWhere('amenities', 'like', "%{$searchRoot}%");
                });
            } else {
                $isAreaBased = in_array($propType, [
                    'terreno', 'terrenos',
                    'escritório', 'escritorio', 'escritorios',
                    'loja', 'lojas',
                    'armazem', 'armazens', 'armazém',
                    'espaco-comercial', 'espacos-comerciais', 'espaços_comerciais', 'espacos-comercias',
                    'empreendimento', 'empreendimentos'
                ]);

                if ($isAreaBased) {
                    $areaVal = preg_replace('/\D/', '', $typology);
                    if (is_numeric($areaVal)) {
                        $query->whereRaw("CAST(area AS INTEGER) <= ?", [(int) $areaVal]);
                    }
                } else {
                    if (str_ends_with($typology, '+')) {
                        $num = (int) rtrim($typology, '+');
                        $query->where('bedrooms', '>=', $num);
                    } else {
                        $num = preg_replace('/\D/', '', $typology);
                        if (is_numeric($num)) {
                            $query->where('bedrooms', (int) $num);
                        }
                    }
                }
            }
        }

        // ── Sorting ───────────────────────────────────────────────
        $sort = $request->input('sort', 'recentes');
        match ($sort) {
            'preco_baixo' => $query->orderBy('price', 'asc'),
            'preco_alto' => $query->orderBy('price', 'desc'),
            default => $query->latest(),
        };

        // ── Dynamic filter options — cached for performance ────────
        // Countries list: changes very rarely → cache 24h
        $countries = Cache::remember('filter.countries', 86400, function () {
            return Property::where('is_active', true)
                ->distinct()
                ->orderBy('country')
                ->pluck('country')
                ->filter()          // remove nulls
                ->map(fn($v) => (string) $v)  // always strings
                ->values()
                ->toArray();        // plain array — safe to cache & iterate
        });

        // Cities list: varies by selected country → cache key includes country
        // e.g. "filter.cities.angola", "filter.cities.all"
        $countrySuffix = $request->filled('country')
            ? strtolower(preg_replace('/\s+/', '_', $request->input('country')))
            : 'all';

        $cities = Cache::remember("filter.cities.{$countrySuffix}", 3600, function () use ($request) {
            return Property::where('is_active', true)
                ->when($request->filled('country'), fn($q) => $q->where('country', $request->input('country')))
                ->distinct()
                ->orderBy('city')
                ->pluck('city')
                ->filter()          // remove nulls
                ->map(fn($v) => (string) $v)  // always strings
                ->values()
                ->toArray();        // plain array — safe to cache & iterate
        });

        // ── Paginate (index scan — fast even on 100k rows) ────────
        $properties = $query->paginate(9)->withQueryString();

        // ── JSON response for infinite-scroll AJAX requests ───────
        if ($request->wantsJson() || $request->ajax() || $request->has('ajax')) {
            $nextPageUrl = $properties->nextPageUrl();
            $relativeNextPageUrl = $nextPageUrl ? parse_url($nextPageUrl, PHP_URL_PATH) . '?' . parse_url($nextPageUrl, PHP_URL_QUERY) : null;

            return response()->json([
                'properties' => $properties->getCollection()->map(fn($p) => [
                    'id' => $p->id,
                    'title' => $p->title,
                    'type' => $p->type,
                    'category' => $p->category,
                    'property_type' => $p->property_type,
                    'property_type_label' => $p->property_type_label,
                    'price' => $p->price,
                    'price_period' => $p->price_period,
                    'city' => $p->city,
                    'country' => $p->country,
                    'bedrooms' => (int) $p->bedrooms,
                    'bathrooms' => (int) $p->bathrooms,
                    'garages' => (int) $p->garages,
                    'area' => $p->area,
                    'image_url' => $p->image_url,
                    'business_label' => $p->business_badge['label'],
                    'business_badge' => $p->business_badge,
                    'url' => route('properties.show', $p),
                ]),
                'hasMore' => $properties->hasMorePages(),
                'currentPage' => $properties->currentPage(),
                'nextPageUrl' => $relativeNextPageUrl,
                'lastPage' => $properties->lastPage(),
                'total' => $properties->total(),
            ]);
        }

        $sections = PageSection::getForPage('imoveis');

        return view('pages.imoveis', compact('properties', 'countries', 'cities', 'sections'));
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
