<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class LandType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class, 'land_type', 'slug');
    }

    /**
     * Retorna o mapa de classificações de terrenos em formato [slug => Nome]:
     * ['urbanos' => 'Urbano', 'rusticos' => 'Rústico', ...]
     */
    public static function typeMap(): array
    {
        return Cache::remember('land_types.map', 3600, function () {
            $types = static::where('is_active', true)
                ->orderBy('order')
                ->orderBy('name')
                ->pluck('name', 'slug')
                ->toArray();

            if (empty($types)) {
                return [
                    'urbanos'           => 'Urbano',
                    'rusticos'          => 'Rústico',
                    'industriais'       => 'Industrial',
                    'projecto-aprovado' => 'Projecto Aprovado',
                ];
            }

            return $types;
        });
    }

    public static function clearTypeCache(): void
    {
        Cache::forget('land_types.map');
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
