<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertyType;
use App\Models\Property;
use Illuminate\Support\Str;

class PropertyTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Apartamentos',      'slug' => 'apartamento',      'nature' => 'residential', 'order' => 1],
            ['name' => 'Vivendas',          'slug' => 'vivenda',          'nature' => 'residential', 'order' => 2],
            ['name' => 'Lojas',             'slug' => 'loja',             'nature' => 'area_based',   'order' => 3],
            ['name' => 'Escritórios',       'slug' => 'escritorio',       'nature' => 'area_based',   'order' => 4],
            ['name' => 'Armazéns',          'slug' => 'armazem',          'nature' => 'area_based',   'order' => 5],
            ['name' => 'Terrenos',          'slug' => 'terreno',          'nature' => 'area_based',   'order' => 6],
            ['name' => 'Espaços Comerciais','slug' => 'espaco-comercial', 'nature' => 'area_based',   'order' => 7],
            ['name' => 'Empreendimentos',   'slug' => 'empreendimento',   'nature' => 'residential', 'order' => 8],
        ];

        foreach ($types as $type) {
            PropertyType::firstOrCreate(
                ['slug' => $type['slug']],
                [
                    'name'      => $type['name'],
                    'nature'    => $type['nature'],
                    'order'     => $type['order'],
                    'is_active' => true,
                ]
            );
        }

        // Também garantir que quaisquer tipos existentes nos imóveis sejam cadastrados
        $existingTypes = Property::distinct()->pluck('property_type')->filter();
        foreach ($existingTypes as $pt) {
            $slug = Str::slug($pt);
            if (!empty($slug)) {
                PropertyType::firstOrCreate(
                    ['slug' => $slug],
                    [
                        'name'      => ucfirst($pt),
                        'nature'    => 'residential',
                        'order'     => 99,
                        'is_active' => true,
                    ]
                );
            }
        }

        PropertyType::clearTypeCache();
    }
}
