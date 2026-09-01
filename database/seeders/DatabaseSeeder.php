<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use App\Models\ContactMessage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@timetochoose.ao'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('admin123'),
            ]
        );

        // Seeded properties
        $properties = [
            [
                'title'         => 'Apartamento Premium T3 — Talatona',
                'description'   => 'Apartamento moderno e espaçoso com acabamentos de luxo, localizado no coração de Talatona. Luminoso, com varandas amplas e vista desafogada. Inclui serviço de condomínio completo, piscina e segurança 24h.',
                'price'         => '350.000 Kz',
                'price_period'  => '/ mês',
                'type'          => 'arrendamento',
                'property_type' => 'apartamento',
                'country'       => 'Angola',
                'city'          => 'Luanda',
                'location'      => 'Talatona, Luanda',
                'bedrooms'      => 3,
                'bathrooms'     => 2,
                'garages'       => 1,
                'area'          => '145 m²',
                'image'         => '1.jpeg',
                'gallery'       => ['2.jpeg', '3.jpeg'],
                'amenities'     => ['Piscina', 'Segurança 24h', 'Ginásio', 'Ar Condicionado', 'Internet Fibra'],
                'is_featured'   => true,
                'status'        => 'disponivel',
            ],
            [
                'title'         => 'Vivenda Luxo com Piscina — Miramar',
                'description'   => 'Vivenda de alto padrão com jardim privativo e piscina aquecida. Localizada num condomínio fechado de prestígio em Miramar, com fácil acesso à Marginal de Luanda. Acabamentos de topo, cozinha equipada e garagem para 3 viaturas.',
                'price'         => '750.000 Kz',
                'price_period'  => '/ mês',
                'type'          => 'arrendamento',
                'property_type' => 'vivenda',
                'country'       => 'Angola',
                'city'          => 'Luanda',
                'location'      => 'Miramar, Luanda',
                'bedrooms'      => 5,
                'bathrooms'     => 4,
                'garages'       => 3,
                'area'          => '420 m²',
                'image'         => '2.jpeg',
                'gallery'       => ['1.jpeg', '3.jpeg'],
                'amenities'     => ['Piscina Privada', 'Jardim', 'Segurança 24h', 'Gerador', 'Garagem Tripla'],
                'is_featured'   => true,
                'status'        => 'disponivel',
            ],
            [
                'title'         => 'Escritório Executivo — Ingombota',
                'description'   => 'Espaço de escritório moderno no centro financeiro de Luanda. Planta aberta com salas de reunião, receção e estacionamento privativo. Ideal para empresas que procuram uma localização estratégica e uma imagem corporativa de prestígio.',
                'price'         => '280.000 Kz',
                'price_period'  => '/ mês',
                'type'          => 'arrendamento',
                'property_type' => 'escritório',
                'country'       => 'Angola',
                'city'          => 'Luanda',
                'location'      => 'Ingombota, Luanda',
                'bedrooms'      => 0,
                'bathrooms'     => 2,
                'garages'       => 5,
                'area'          => '210 m²',
                'image'         => '3.jpeg',
                'gallery'       => ['1.jpeg', '2.jpeg'],
                'amenities'     => ['Ar Condicionado Central', 'Internet Fibra', 'Gerador', 'CCTV', 'Recepção'],
                'is_featured'   => true,
                'status'        => 'disponivel',
            ],
            [
                'title'         => 'Apartamento Moderno T2 — Kilamba',
                'description'   => 'Apartamento bem localizado na Cidade do Kilamba, com acabamentos modernos e infraestrutura de alta qualidade. Condomínio seguro com áreas verdes, parques de lazer e acesso rápido às principais vias de comunicação.',
                'price'         => '180.000 Kz',
                'price_period'  => '/ mês',
                'type'          => 'arrendamento',
                'property_type' => 'apartamento',
                'country'       => 'Angola',
                'city'          => 'Luanda',
                'location'      => 'Kilamba, Luanda',
                'bedrooms'      => 2,
                'bathrooms'     => 1,
                'garages'       => 1,
                'area'          => '98 m²',
                'image'         => '1.jpeg',
                'gallery'       => ['2.jpeg'],
                'amenities'     => ['Segurança 24h', 'Áreas Verdes', 'Ar Condicionado'],
                'is_featured'   => false,
                'status'        => 'disponivel',
            ],
            [
                'title'         => 'Moradia Independente T4 — Belas',
                'description'   => 'Moradia independente com quintal privativo e garagem dupla. Localizada no Belas Shopping District, próxima de escolas internacionais, centros comerciais e clínicas médicas. Ideal para famílias que procuram conforto e segurança.',
                'price'         => '480.000 Kz',
                'price_period'  => '/ mês',
                'type'          => 'arrendamento',
                'property_type' => 'vivenda',
                'country'       => 'Angola',
                'city'          => 'Luanda',
                'location'      => 'Belas, Luanda',
                'bedrooms'      => 4,
                'bathrooms'     => 3,
                'garages'       => 2,
                'area'          => '280 m²',
                'image'         => '2.jpeg',
                'gallery'       => ['1.jpeg', '3.jpeg'],
                'amenities'     => ['Quintal Privativo', 'Garagem Dupla', 'Gerador', 'Segurança 24h'],
                'is_featured'   => true,
                'status'        => 'reservado',
            ],
            [
                'title'         => 'Terreno Urbano — Benfica',
                'description'   => 'Terreno plano de excelente dimensão em zona habitacional consolidada no Benfica. Ideal para construção de moradia unifamiliar ou condomínio pequeno. Totalmente vedado, com acesso fácil e eletricidade.',
                'price'         => '45.000.000 Kz',
                'price_period'  => null,
                'type'          => 'venda',
                'property_type' => 'terreno',
                'country'       => 'Angola',
                'city'          => 'Luanda',
                'location'      => 'Benfica, Luanda',
                'bedrooms'      => 0,
                'bathrooms'     => 0,
                'garages'       => 0,
                'area'          => '1,5 ha',
                'image'         => '3.jpeg',
                'gallery'       => [],
                'amenities'     => ['Acesso Asfaltado', 'Furo de Água', 'Vedado'],
                'is_featured'   => false,
                'status'        => 'disponivel',
            ],
            // International Properties
            [
                'title'         => 'Apartamento Luxo T2 Vista Rio — Lisboa',
                'description'   => 'Excelente apartamento T2 localizado no prestigiado Parque das Nações em Lisboa, Portugal. Totalmente mobilado com design contemporâneo, cozinha equipada de gama alta e vista deslumbrante sobre o Rio Tejo.',
                'price'         => '2.500 EUR',
                'price_period'  => '/ mês',
                'type'          => 'arrendamento',
                'property_type' => 'apartamento',
                'country'       => 'Portugal',
                'city'          => 'Lisboa',
                'location'      => 'Parque das Nações, Lisboa',
                'bedrooms'      => 2,
                'bathrooms'     => 2,
                'garages'       => 1,
                'area'          => '110 m²',
                'image'         => '1.jpeg',
                'gallery'       => ['2.jpeg'],
                'amenities'     => ['Vista Rio', 'Garagem', 'Ar Condicionado', 'Mobiliado', 'Segurança'],
                'is_featured'   => true,
                'status'        => 'disponivel',
            ],
            [
                'title'         => 'Vivenda Exclusiva V4 com Jardim — Pretória',
                'description'   => 'Magnífica vivenda localizada em condomínio de prestígio em Pretória, África do Sul. Amplo quintal com piscina privativa, deck exterior, cozinha exterior para barbecue, e acabamentos clássicos de alto luxo.',
                'price'         => '4.200 USD',
                'price_period'  => '/ mês',
                'type'          => 'arrendamento',
                'property_type' => 'vivenda',
                'country'       => 'África do Sul',
                'city'          => 'Pretória',
                'location'      => 'Waterkloof, Pretória',
                'bedrooms'      => 4,
                'bathrooms'     => 3,
                'garages'       => 2,
                'area'          => '350 m²',
                'image'         => '2.jpeg',
                'gallery'       => ['3.jpeg'],
                'amenities'     => ['Piscina Privada', 'Jardim Amplo', 'Segurança Armada', 'Deck de Barbecue', 'Garagem Dupla'],
                'is_featured'   => true,
                'status'        => 'disponivel',
            ],
        ];

        foreach ($properties as $data) {
            Property::create($data);
        }

        // Sample contact messages
        ContactMessage::create([
            'name'    => 'Carlos Mendes',
            'email'   => 'carlos@email.com',
            'phone'   => '+244 912 345 678',
            'message' => 'Tenho interesse no apartamento T3 em Talatona. Pode enviar mais informações e agendar uma visita?',
            'property_id' => 1,
            'is_read' => false,
        ]);

        ContactMessage::create([
            'name'    => 'Ana Rodrigues',
            'email'   => 'ana@empresa.ao',
            'phone'   => '+244 923 456 789',
            'message' => 'Gostaríamos de visitar o escritório executivo na Ingombota. Qual a disponibilidade para uma reunião?',
            'property_id' => 3,
            'is_read' => false,
        ]);

        $this->call(LandTypeSeeder::class);
        $this->call(LandClassificationSeeder::class);
    }
}
