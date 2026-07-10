<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\ContactMessage;
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
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
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
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'nullable|string|max:100',
            'price_period'  => 'nullable|string|max:50',
            'type'          => 'required|in:arrendamento,venda',
            'property_type' => 'required|string|max:100',
            'country'       => 'required|string|max:100',
            'city'          => 'required|string|max:100',
            'location'      => 'nullable|string|max:255',
            'bedrooms'      => 'nullable|integer|min:0',
            'bathrooms'     => 'nullable|integer|min:0',
            'garages'       => 'nullable|integer|min:0',
            'area'          => 'nullable|string|max:50',
            'status'        => 'required|in:disponivel,reservado,vendido,arrendado',
            'is_featured'   => 'boolean',
            'is_active'     => 'boolean',
            'amenities'     => 'nullable|string',
            'image'         => 'nullable|image|max:5120',
            'gallery.*'     => 'nullable|image|max:5120',
            'video_url'     => 'nullable|string|max:255',
            'tour_3d_url'   => 'nullable|string|max:255',
            'latitude'      => 'nullable|string|max:50',
            'longitude'     => 'nullable|string|max:50',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);

        // Parse amenities
        if (isset($data['amenities']) && is_string($data['amenities'])) {
            $data['amenities'] = array_filter(array_map('trim', explode(',', $data['amenities'])));
        }

        // Upload main image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('properties', 'public');
            $data['image'] = $path;
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
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'nullable|string|max:100',
            'price_period'  => 'nullable|string|max:50',
            'type'          => 'required|in:arrendamento,venda',
            'property_type' => 'required|string|max:100',
            'country'       => 'required|string|max:100',
            'city'          => 'required|string|max:100',
            'location'      => 'nullable|string|max:255',
            'bedrooms'      => 'nullable|integer|min:0',
            'bathrooms'     => 'nullable|integer|min:0',
            'garages'       => 'nullable|integer|min:0',
            'area'          => 'nullable|string|max:50',
            'status'        => 'required|in:disponivel,reservado,vendido,arrendado',
            'is_featured'   => 'boolean',
            'is_active'     => 'boolean',
            'amenities'     => 'nullable|string',
            'image'         => 'nullable|image|max:5120',
            'gallery.*'     => 'nullable|image|max:5120',
            'video_url'     => 'nullable|string|max:255',
            'tour_3d_url'   => 'nullable|string|max:255',
            'latitude'      => 'nullable|string|max:50',
            'longitude'     => 'nullable|string|max:50',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);

        if (isset($data['amenities']) && is_string($data['amenities'])) {
            $data['amenities'] = array_filter(array_map('trim', explode(',', $data['amenities'])));
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('properties', 'public');
            $data['image'] = $path;
        } else {
            unset($data['image']);
        }

        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('properties', 'public');
            }
            $data['gallery'] = $gallery;
        } else {
            unset($data['gallery']);
        }

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
}
