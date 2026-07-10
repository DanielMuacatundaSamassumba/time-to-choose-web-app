<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class TestPropertiesSeeder extends Seeder
{
    public function run(): void
    {
        $baseProperties = Property::all();
        if ($baseProperties->isEmpty()) {
            $this->command->error("Nenhum imóvel base encontrado para replicar. Execute o DatabaseSeeder primeiro.");
            return;
        }

        $count = 0;
        foreach ($baseProperties as $p) {
            for ($i = 1; $i <= 6; $i++) {
                $clone = $p->replicate();
                $clone->title = $p->title . " (Cópia #{$i})";
                
                // Let's set some random variations for variety
                $clone->is_featured = (rand(1, 10) > 6);
                
                // Keep image references correct
                $clone->image = $p->image;
                $clone->gallery = $p->gallery;
                $clone->amenities = $p->amenities;

                $clone->save();
                $count++;
            }
        }

        $this->command->info("Criados com sucesso {$count} novos imóveis de teste!");
    }
}
