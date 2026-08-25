<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function cities()
    {
        return $this->hasMany(City::class)->orderBy('name');
    }

    /**
     * Retorna o mapa de países e cidades estruturado:
     * ['Angola' => ['Luanda', 'Benguela'], 'Portugal' => ['Lisboa', ...]]
     */
    public static function getCityMap(): array
    {
        return Cache::remember('locations.city_map', 3600, function () {
            $countries = static::where('is_active', true)
                ->with(['cities' => fn($q) => $q->where('is_active', true)])
                ->orderBy('name')
                ->get();

            $map = [];
            foreach ($countries as $country) {
                $map[$country->name] = $country->cities->pluck('name')->values()->toArray();
            }

            return $map;
        });
    }

    /**
     * Limpa o cache das localizações
     */
    public static function clearLocationCache(): void
    {
        Cache::forget('locations.city_map');
        Cache::forget('filter.countries');
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::clearLocationCache());
        static::deleted(fn () => static::clearLocationCache());
    }
}
