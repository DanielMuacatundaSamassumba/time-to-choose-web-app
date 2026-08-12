<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'price', 'price_period', 'type', 'category', 'property_type',
        'country', 'city', 'location', 'bedrooms', 'bathrooms', 'garages', 'area',
        'image', 'gallery', 'amenities', 'is_featured', 'is_active', 'status',
        'video_url', 'tour_3d_url', 'latitude', 'longitude'
    ];

    protected $casts = [
        'gallery'     => 'array',
        'amenities'   => 'array',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    // ── Route-model binding via slug ──────────────────────────────────────────
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ── Auto-generate unique slug on create/update ────────────────────────────
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Property $property) {
            if (empty($property->slug)) {
                $property->slug = static::generateUniqueSlug($property->title, null);
            }
        });

        static::updating(function (Property $property) {
            // Regenerate slug only if title changed and slug was not manually set
            if ($property->isDirty('title') && !$property->isDirty('slug')) {
                $property->slug = static::generateUniqueSlug($property->title, $property->id);
            }
        });
    }

    public static function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $base = Str::slug($title);

        if (empty($base)) {
            $base = 'imovel';
        }

        $slug = $base;
        $i    = 1;

        while (
            static::where('slug', $slug)
                  ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                  ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    // ── Relationships ─────────────────────────────────────────────────────────
    public function messages()
    {
        return $this->hasMany(ContactMessage::class);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────
    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('assets/' . $this->image))) {
            return asset('assets/' . $this->image);
        }
        if ($this->image && file_exists(public_path($this->image))) {
            return asset($this->image);
        }
        if ($this->image && str_starts_with($this->image, 'properties/')) {
            return \Illuminate\Support\Facades\Storage::url($this->image);
        }
        return asset('assets/1.jpeg');
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'reservado' => ['label' => 'Reservado', 'class' => 'bg-yellow-100 text-yellow-700'],
            'vendido'   => ['label' => 'Vendido',   'class' => 'bg-red-100 text-red-700'],
            'arrendado' => ['label' => 'Arrendado', 'class' => 'bg-blue-100 text-blue-700'],
            default     => ['label' => 'Disponível','class' => 'bg-green-100 text-green-700'],
        };
    }

    public function getTypologyDisplayAttribute(): string
    {
        if (in_array(strtolower($this->property_type), ['apartamento', 'casa', 'moradia'])) {
            return 'T' . $this->bedrooms;
        }
        if (strtolower($this->property_type) === 'vivenda') {
            return 'V' . $this->bedrooms;
        }
        if (strtolower($this->property_type) === 'terreno') {
            return $this->area ?: 'Terreno';
        }
        return $this->bedrooms > 0 ? 'T' . $this->bedrooms : ($this->area ?: ucfirst($this->property_type));
    }
}
