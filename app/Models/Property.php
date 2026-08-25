<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'price', 'price_period', 'type', 'category', 'property_type', 'land_type',
        'country', 'city', 'location', 'bedrooms', 'bathrooms', 'garages', 'area',
        'image', 'gallery', 'amenities', 'is_featured', 'is_active', 'status',
        'video_url', 'tour_3d_url', 'latitude', 'longitude',
        'owner_name', 'owner_phone', 'owner_whatsapp', 'owner_email', 'owner_website'
    ];

    protected $hidden = [
        'owner_name', 'owner_phone', 'owner_whatsapp', 'owner_email', 'owner_website'
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

    // ── Classificação de Terrenos ──────────────────────────────────────────
    public static function landTypes(): array
    {
        return [
            'urbanos'           => 'Urbano',
            'rusticos'          => 'Rústico',
            'industriais'       => 'Industrial',
            'projecto-aprovado' => 'Projecto Aprovado',
        ];
    }

    public function getLandTypeLabelAttribute(): ?string
    {
        if (empty($this->land_type)) return null;
        $types = static::landTypes();
        return $types[$this->land_type] ?? ucfirst($this->land_type);
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

    public function getPriceAttribute($value): ?string
    {
        if (!$value) {
            return $value;
        }

        if (stripos($value, 'sob consulta') !== false) {
            return 'Sob Consulta';
        }

        if (preg_match('/^(\d+)(\s*.*)$/', trim($value), $matches)) {
            $num = (float) $matches[1];
            $formatted = number_format($num, 0, ',', '.');
            $suffix = $matches[2];
            return $formatted . $suffix;
        }

        return $value;
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

    public function getBusinessBadgeAttribute(): array
    {
        $cat = strtolower((string) ($this->category ?? ''));
        $type = strtolower((string) ($this->type ?? ''));

        if ($cat === 'arrendamento-longa-duracao') {
            return [
                'label'       => 'Longa Duração',
                'short_label' => 'Longa Duração',
                'bg'          => '#2563EB',
                'color'       => '#ffffff',
                'class'       => 'bg-[#2563EB] text-white',
            ];
        }

        if ($cat === 'arrendamento-curta-duracao') {
            return [
                'label'       => 'Curta Duração',
                'short_label' => 'Curta Duração',
                'bg'          => '#FFD166',
                'color'       => '#111827',
                'class'       => 'bg-[#FFD166] text-black',
            ];
        }

        if ($cat === 'transpasse' || $type === 'transpasse') {
            return [
                'label'       => 'Transpasse',
                'short_label' => 'Transpasse',
                'bg'          => '#8B5CF6',
                'color'       => '#ffffff',
                'class'       => 'bg-[#8B5CF6] text-white',
            ];
        }

        if ($type === 'arrendamento') {
            return [
                'label'       => 'Arrendamento',
                'short_label' => 'Arrendamento',
                'bg'          => '#FFD166',
                'color'       => '#000000',
                'class'       => 'bg-[#FFD166] text-black',
            ];
        }

        return [
            'label'       => 'Venda',
            'short_label' => 'Venda',
            'bg'          => '#F97316',
            'color'       => '#ffffff',
            'class'       => 'bg-[#F97316] text-white',
        ];
    }

    public function getBusinessLabelAttribute(): string
    {
        return $this->business_badge['label'];
    }

    // ── Tipos de Imóveis (Centralizado & Extensível via CMS) ─────────────────
    public static function propertyTypes(): array
    {
        return PropertyType::typeMap();
    }

    public function getPropertyTypeLabelAttribute(): string
    {
        $types = static::propertyTypes();
        $raw = trim((string) ($this->property_type ?? ''));
        $key = strtolower($raw);

        if (isset($types[$key])) {
            return $types[$key];
        }

        // Mapeamento flexível para registos existentes ou variações com/sem acento
        if (str_contains($key, 'comercia')) return 'Espaços Comerciais';
        if (str_contains($key, 'escrit'))   return 'Escritórios';
        if (str_contains($key, 'armaz'))    return 'Armazéns';
        if (str_contains($key, 'terren'))   return 'Terrenos';
        if (str_contains($key, 'vivend'))   return 'Vivendas';
        if (str_contains($key, 'apart'))    return 'Apartamentos';
        if (str_contains($key, 'empreend')) return 'Empreendimentos';
        if (str_contains($key, 'loja'))     return 'Lojas';

        return ucfirst($raw);
    }

    public function getTypologyDisplayAttribute(): string
    {
        $pt = strtolower(trim((string) ($this->property_type ?? '')));

        if (str_contains($pt, 'apart') || str_contains($pt, 'moradia') || $pt === 'casa') {
            return 'T' . ($this->bedrooms ?: 0);
        }
        if (str_contains($pt, 'vivend')) {
            return 'V' . ($this->bedrooms ?: 0);
        }
        if (str_contains($pt, 'terren')) {
            if ($this->land_type_label) {
                return $this->land_type_label . ($this->area ? ' (' . $this->area . ')' : '');
            }
            return $this->area ?: 'Terreno';
        }

        // Para outros tipos de imóveis não consta nem T nem V
        if (!empty($this->area)) {
            return $this->area;
        }

        return $this->property_type_label;
    }
}
