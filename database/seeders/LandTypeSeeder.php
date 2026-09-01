<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandType;

class LandTypeSeeder extends Seeder
{
    /**
     * Seeder apenas para o catálogo de classificações de terrenos.
     */
    public function run(): void
    {
        $classifications = [
            [
                'name'        => 'Urbano',
                'slug'        => 'urbanos',
                'description' => 'Terrenos situados em malha urbana com infraestruturas para habitação, comércio ou serviços.',
                'order'       => 1,
            ],
            [
                'name'        => 'Rústico',
                'slug'        => 'rusticos',
                'description' => 'Terrenos destinados à exploração agrícola, florestal, pecuária ou de lazer no meio rural.',
                'order'       => 2,
            ],
            [
                'name'        => 'Industrial',
                'slug'        => 'industriais',
                'description' => 'Terrenos localizados em polos ou zonas industriais para armazéns, logística ou fábricas.',
                'order'       => 3,
            ],
            [
                'name'        => 'Projecto Aprovado',
                'slug'        => 'projecto-aprovado',
                'description' => 'Terrenos com projectos de arquitectura/engenharia e licenças municipais prontas para início de obra.',
                'order'       => 4,
            ],
        ];

        foreach ($classifications as $data) {
            LandType::firstOrCreate(
                ['slug' => $data['slug']],
                [
                    'name'        => $data['name'],
                    'description' => $data['description'],
                    'order'       => $data['order'],
                    'is_active'   => true,
                ]
            );
        }

        LandType::clearTypeCache();

        if (isset($this->command)) {
            $this->command->info('✅ LandTypeSeeder: 4 classificações de terrenos inseridas com sucesso!');
        }
    }
}
