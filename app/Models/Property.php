<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'price', 'price_period', 'type', 'property_type',
        'country', 'city', 'location', 'bedrooms', 'bathrooms', 'garages', 'area',
        'image', 'gallery', 'amenities', 'is_featured', 'is_active', 'status',
        'video_url', 'tour_3d_url', 'latitude', 'longitude'
    ];

    protected $casts = [
        'gallery'    => 'array',
        'amenities'  => 'array',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function messages()
    {
        return $this->hasMany(ContactMessage::class);
    }

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

    // Dynamic typology label accessor
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
        // Fallback
        return $this->bedrooms > 0 ? 'T' . $this->bedrooms : ($this->area ?: ucfirst($this->property_type));
    }
}
