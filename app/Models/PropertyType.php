<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PropertyType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'nature',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class, 'property_type', 'slug');
    }

    /**
     * Retorna o mapa de tipos de imóveis em formato [slug => Nome]:
     * ['apartamento' => 'Apartamentos', 'vivenda' => 'Vivendas', ...]
     */
    public static function typeMap(): array
    {
        return Cache::remember('property_types.map', 3600, function () {
            $types = static::where('is_active', true)
                ->orderBy('order')
                ->orderBy('name')
                ->pluck('name', 'slug')
                ->toArray();

            if (empty($types)) {
                return [
                    'apartamento'      => 'Apartamentos',
                    'vivenda'          => 'Vivendas',
                    'loja'             => 'Lojas',
                    'escritorio'       => 'Escritórios',
                    'armazem'          => 'Armazéns',
                    'terreno'          => 'Terrenos',
                    'espaco-comercial' => 'Espaços Comerciais',
                    'empreendimento'   => 'Empreendimentos',
                ];
            }

            return $types;
        });
    }

    public static function clearTypeCache(): void
    {
        Cache::forget('property_types.map');
    }

    protected static function booted(): void
    {
        static::saving(function ($type) {
            if (empty($type->slug)) {
                $type->slug = Str::slug($type->name);
            }
        });

        static::saved(fn () => static::clearTypeCache());
        static::deleted(fn () => static::clearTypeCache());
    }
}
