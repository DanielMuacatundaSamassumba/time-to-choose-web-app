<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\ContactMessage;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_properties'  => Property::count(),
            'active_properties' => Property::where('is_active', true)->count(),
            'featured'          => Property::where('is_featured', true)->count(),
            'new_messages'      => ContactMessage::where('is_read', false)->count(),
            'total_messages'    => ContactMessage::count(),
        ];

        $recentProperties = Property::latest()->take(5)->get();
        $recentMessages   = ContactMessage::with('property')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentProperties', 'recentMessages'));
    }

    // ─── Properties ─────────────────────────────────────────────────────────────

    public function propertiesIndex(Request $request)
    {
        $query = Property::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('owner_phone', 'like', "%{$search}%");
            });
        }

        // Unified filter — mirrors the menu and public page selects
        if ($request->filled('filter_category')) {
            $fc = $request->input('filter_category');
            if ($fc === 'venda') {
                $query->where('type', 'venda');
            } elseif (in_array($fc, ['arrendamento-longa-duracao', 'arrendamento-curta-duracao', 'transpasse'])) {
                $query->where('category', $fc);
            }
        }

        if ($request->filled('property_type')) {
            $pt = strtolower($request->input('property_type'));
            $query->where('property_type', 'like', '%' . $pt . '%');
        }

        if ($request->filled('land_type')) {
            $lt = strtolower($request->input('land_type'));
            $query->where(function ($q) use ($lt) {
                $q->where('land_type', $lt)
                  ->orWhere('land_type', 'like', "%{$lt}%");
            });
        }

        if ($request->filled('country')) {
            $query->where('country', $request->input('country'));
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->input('city') . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $properties = $query->latest()->paginate(10)->withQueryString();
        return view('admin.properties.index', compact('properties'));
    }

    public function propertiesCreate()
    {
        return view('admin.properties.create');
    }

    public function propertiesStore(Request $request)
    {
        $request->merge([
            'bedrooms'  => $request->input('bedrooms') ?: 0,
            'bathrooms' => $request->input('bathrooms') ?: 0,
            'garages'   => $request->input('garages') ?: 0,
        ]);

        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'price_amount'      => 'nullable|string|max:100',
            'price_currency'    => 'nullable|string|max:50',
            'price'             => 'nullable|string|max:100',
            'price_period'      => 'nullable|string|max:50',
            'business_category' => 'required|in:venda,arrendamento-longa-duracao,arrendamento-curta-duracao,transpasse',
            'property_type'     => 'required|string|max:100',
            'land_type'         => 'nullable|string|max:100',
            'country'           => 'required|string|max:100',
            'city'              => 'required|string|max:100',
            'location'          => 'nullable|string|max:255',
            'bedrooms'          => 'nullable|integer|min:0',
            'bathrooms'         => 'nullable|integer|min:0',
            'garages'           => 'nullable|integer|min:0',
            'area'              => 'nullable|string|max:50',
            'status'            => 'required|in:disponivel,reservado,vendido,arrendado',
            'is_featured'       => 'boolean',
            'is_active'         => 'boolean',
            'amenities'         => 'nullable|string',
            'image'             => 'nullable|image|max:51200',
            'gallery.*'         => 'nullable|image|max:51200',
            'video_url'         => 'nullable|string|max:255',
            'tour_3d_url'       => 'nullable|string|max:255',
            'latitude'          => 'nullable|string|max:50',
            'longitude'         => 'nullable|string|max:50',
            'owner_name'        => 'nullable|string|max:255',
            'owner_phone'       => 'nullable|string|max:50',
            'owner_whatsapp'    => 'nullable|string|max:50',
            'owner_email'       => 'nullable|email|max:255',
            'owner_website'     => 'nullable|string|max:255',
        ]);

        // Derive type + category from the unified business_category field
        $bc = $request->input('business_category');
  $type = $bc === 'venda'
    ? 'venda'
    : ($bc === 'transpasse' ? 'Transpasse' : 'arrendamento');
        $category = $bc !== 'venda' ? $bc : null;

        $data = $request->except(['_token', 'business_category', 'price_amount', 'price_currency']);
        $data['type']        = $type;
        $data['category']    = $category;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->has('is_active') ? $request->boolean('is_active') : true;

        // Process price amount + currency (format with dots from 1.000)
        $currency = $request->input('price_currency', 'Kz');
        $amount = trim((string) $request->input('price_amount', $request->input('price', '')));
        if ($currency === 'Sob Consulta') {
            $data['price'] = 'Sob Consulta';
        } elseif (!empty($amount)) {
            $digits = preg_replace('/[^\d]/', '', $amount);
            if (is_numeric($digits) && strlen($digits) > 0) {
                $formatted = number_format((float) $digits, 0, ',', '.');
                $data['price'] = $formatted . ' ' . $currency;
            } else {
                $data['price'] = $amount . ' ' . $currency;
            }
        } else {
            $data['price'] = null;
        }

        $data['price_period'] = $request->filled('price_period') ? $request->input('price_period') : null;

        // Parse amenities
        if (isset($data['amenities']) && is_string($data['amenities'])) {
            $data['amenities'] = array_filter(array_map('trim', explode(',', $data['amenities'])));
        }

        // Upload main image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('properties', 'public');
        }

        // Upload gallery
        $gallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('properties', 'public');
            }
        }
        $data['gallery'] = $gallery ?: null;

        Property::create($data);

        return redirect()->route('admin.properties.index')
                         ->with('success', 'Imóvel criado com sucesso!');
    }

    public function propertiesEdit(Property $property)
    {
        return view('admin.properties.edit', compact('property'));
    }

    public function propertiesUpdate(Request $request, Property $property)
    {
      $request->merge([
        'bedrooms'  => $request->input('bedrooms') ?: 0,
        'bathrooms' => $request->input('bathrooms') ?: 0,
        'garages'   => $request->input('garages') ?: 0,
    ]);

    $validated = $request->validate([
        'title'             => 'required|string|max:255',
        'description'       => 'nullable|string',
        'price_amount'      => 'nullable|string|max:100',
        'price_currency'    => 'nullable|string|max:50',
        'price'             => 'nullable|string|max:100',
        'price_period'      => 'nullable|string|max:50',
        'business_category' => 'required|in:venda,arrendamento-longa-duracao,arrendamento-curta-duracao,transpasse',
        'property_type'     => 'required|string|max:100',
        'land_type'         => 'nullable|string|max:100',
        'country'           => 'required|string|max:100',
        'city'              => 'required|string|max:100',
        'location'          => 'nullable|string|max:255',

        'bedrooms'          => 'required|integer|min:0',
        'bathrooms'         => 'required|integer|min:0',
        'garages'           => 'required|integer|min:0',

        'area'              => 'nullable|string|max:50',
        'status'            => 'required|in:disponivel,reservado,vendido,arrendado',
        'is_featured'       => 'boolean',
        'is_active'         => 'boolean',
        'amenities'         => 'nullable|string',
        'image'             => 'nullable|image|max:51200',
        'gallery.*'         => 'nullable|image|max:51200',
        'video_url'         => 'nullable|string|max:255',
        'tour_3d_url'       => 'nullable|string|max:255',
        'latitude'          => 'nullable|string|max:50',
        'longitude'         => 'nullable|string|max:50',
        'owner_name'        => 'nullable|string|max:255',
        'owner_phone'       => 'nullable|string|max:50',
        'owner_whatsapp'    => 'nullable|string|max:50',
        'owner_email'       => 'nullable|email|max:255',
        'owner_website'     => 'nullable|string|max:255',
    ]);

        // Derive type + category from the unified business_category field
        $bc = $request->input('business_category');
        $type = $bc === 'venda'
            ? 'venda'
            : ($bc === 'transpasse' ? 'Transpasse' : 'arrendamento');
        $category = $bc !== 'venda' ? $bc : null;

        $data = $request->except(['_token', '_method', 'business_category', 'price_amount', 'price_currency']);
        $data['type']        = $type;
        $data['category']    = $category;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active');

        // Process price amount + currency (format with dots from 1.000)
        $currency = $request->input('price_currency', 'Kz');
        $amount = trim((string) $request->input('price_amount', $request->input('price', '')));
        if ($currency === 'Sob Consulta') {
            $data['price'] = 'Sob Consulta';
        } elseif (!empty($amount)) {
            $digits = preg_replace('/[^\d]/', '', $amount);
            if (is_numeric($digits) && strlen($digits) > 0) {
                $formatted = number_format((float) $digits, 0, ',', '.');
                $data['price'] = $formatted . ' ' . $currency;
            } else {
                $data['price'] = $amount . ' ' . $currency;
            }
        } else {
            $data['price'] = null;
        }

        $data['price_period'] = $request->filled('price_period') ? $request->input('price_period') : null;

        if (isset($data['amenities']) && is_string($data['amenities'])) {
            $data['amenities'] = array_filter(array_map('trim', explode(',', $data['amenities'])));
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('properties', 'public');
        } else {
            unset($data['image']);
        }

        // Start from the images already saved for this property
        $gallery = is_array($property->gallery) ? $property->gallery : [];

        // Remove images the user unchecked in the form
        $toRemove = (array) $request->input('remove_gallery', []);
        if (!empty($toRemove)) {
            foreach ($toRemove as $img) {
                if (str_starts_with($img, 'properties/')) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($img);
                }
            }
            $gallery = array_values(array_diff($gallery, $toRemove));
        }

        // Append any newly uploaded images to the existing gallery
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('properties', 'public');
            }
        }

        $data['gallery'] = $gallery ?: null;

        $property->update($data);

        return redirect()->route('admin.properties.index')
                         ->with('success', 'Imóvel actualizado com sucesso!');
    }

    public function propertiesDestroy(Property $property)
    {
        $property->delete();
        return redirect()->route('admin.properties.index')
                         ->with('success', 'Imóvel eliminado com sucesso!');
    }

    public function propertiesShow(Property $property)
    {
        return view('admin.properties.show', compact('property'));
    }

    public function propertiesToggleActive(Property $property)
    {
        $property->update(['is_active' => !$property->is_active]);
        $msg = $property->is_active ? 'Imóvel agora está visível no site!' : 'Imóvel agora está oculto do site público!';
        return back()->with('success', $msg);
    }

    // ─── Messages ────────────────────────────────────────────────────────────────

    public function messagesIndex()
    {
        $messages = ContactMessage::with('property')->latest()->paginate(15);
        ContactMessage::where('is_read', false)->update(['is_read' => true]);
        return view('admin.messages.index', compact('messages'));
    }

    public function messagesDestroy(ContactMessage $message)
    {
        $message->delete();
        return back()->with('success', 'Mensagem eliminada.');
    }

    // ─── Content (Page Sections CMS) ─────────────────────────────────────────

    /**
     * List of all editable pages.
     */
    public function contentIndex()
    {
        $pages = [
            'home' => [
                'label'    => 'Homepage',
                'icon'     => 'fa-house',
                'url'      => '/',
                'thumb'    => 'Real_estate_consultant_welcoming…_202607030647.jpeg',
                'sections' => ['Hero', 'Categorias', 'Destaques', 'Serviços', 'Internacionais', 'CTA', 'SEO'],
                'images'   => ['Hero'],
            ],
            'imoveis' => [
                'label'    => 'Catálogo de Imóveis',
                'icon'     => 'fa-building',
                'url'      => '/imoveis',
                'thumb'    => 'Real_estate_consultant_presentin…_202607021733.jpeg',
                'sections' => ['Hero', 'SEO'],
                'images'   => ['Hero'],
            ],
            'about' => [
                'label'    => 'Sobre Nós',
                'icon'     => 'fa-users',
                'url'      => '/sobre-nos',
                'thumb'    => 'Executives_overlooking_Luanda_sk…_202607031225.jpeg',
                'sections' => ['Hero', 'História', 'Em Números', 'CTA', 'SEO'],
                'images'   => ['Hero', 'História'],
            ],
            'investors' => [
                'label'    => 'Investidores',
                'icon'     => 'fa-chart-line',
                'url'      => '/investidores',
                'thumb'    => 'Real_estate_consultant_presentin…_202607021733.jpeg',
                'sections' => ['Hero', 'Oportunidade', 'Serviços', 'Performance', 'SEO'],
                'images'   => ['Hero', 'Oportunidade'],
            ],
            'valuation' => [
                'label'    => 'Avaliação Imobiliária',
                'icon'     => 'fa-magnifying-glass-dollar',
                'url'      => '/avaliacao-de-imoveis',
                'thumb'    => 'Real_estate_valuation_report_pre…_202607021706.jpeg',
                'sections' => ['Hero', 'Metodologia', 'Objectivos', 'Modalidades', 'SEO'],
                'images'   => ['Hero'],
            ],
            'management' => [
                'label'    => 'Gestão de Propriedades',
                'icon'     => 'fa-screwdriver-wrench',
                'url'      => '/gestao-de-propriedades',
                'thumb'    => 'Property_manager_discussing_perf…_202607021718.jpeg',
                'sections' => ['Hero', 'O Que Fazemos', 'Full-Pack', 'SEO'],
                'images'   => ['Hero', 'Full-Pack'],
            ],
            'partners' => [
                'label'    => 'Propriedades & Parceiros',
                'icon'     => 'fa-handshake',
                'url'      => '/propriedades-e-parceiros',
                'thumb'    => 'An_ultra-realistic_luxury_real_estate_202607021617.jpeg',
                'sections' => ['Hero', 'Proposta de Valor', 'Modelos', 'Como Funciona', 'Full-Pack', 'SEO'],
                'images'   => ['Hero'],
            ],
        ];

        return view('admin.content.index', compact('pages'));
    }

    /**
     * Show the edit form for a specific page.
     */
    public function contentEdit(string $page)
    {
        $allowedPages = ['home', 'imoveis', 'about', 'investors', 'valuation', 'management', 'partners'];
        abort_unless(in_array($page, $allowedPages), 404);

        $sections = PageSection::getForPage($page);

        $pageLabels = [
            'home'       => 'Homepage',
            'imoveis'    => 'Catálogo de Imóveis',
            'about'      => 'Sobre Nós',
            'investors'  => 'Investidores',
            'valuation'  => 'Avaliação Imobiliária',
            'management' => 'Gestão de Propriedades',
            'partners'   => 'Propriedades & Parceiros',
        ];

        $pageLabel = $pageLabels[$page] ?? $page;

        return view('admin.content.edit', compact('page', 'sections', 'pageLabel'));
    }

    /**
     * Save updated section content + images for a specific page.
     */
    public function contentUpdate(Request $request, string $page)
    {
        $allowedPages = ['home', 'imoveis', 'about', 'investors', 'valuation', 'management', 'partners'];
        abort_unless(in_array($page, $allowedPages), 404);

        // ── Handle text fields ────────────────────────────────────────────────
        $input = $request->except(['_token', '_method']);

        foreach ($input as $key => $value) {
            if (str_contains($key, '__') && !($value instanceof \Illuminate\Http\UploadedFile)) {
                [$section, $field] = explode('__', $key, 2);
                PageSection::updateOrCreate(
                    ['page' => $page, 'section' => $section, 'field' => $field],
                    ['value' => $value]
                );
            }
        }

        // ── Handle image uploads ──────────────────────────────────────────────
        // Image input names follow the pattern: img__{section}__{field}
        foreach ($request->allFiles() as $key => $file) {
            if (str_starts_with($key, 'img__')) {
                $parts = explode('__', $key, 3); // ['img', section, field]
                if (count($parts) === 3) {
                    [, $section, $field] = $parts;
                    $path = $file->store('page-images', 'public');
                    PageSection::updateOrCreate(
                        ['page' => $page, 'section' => $section, 'field' => $field],
                        ['value' => $path]
                    );
                }
            }
        }

        return redirect()->route('admin.content.edit', $page)
                         ->with('success', 'Conteúdo actualizado com sucesso!');
    }
}
