<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\City;
use App\Models\Property;

class CountryCitySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Angola' => [
                'code' => 'AO',
                'cities' => ['Luanda', 'Benguela', 'Lubango', 'Cabinda', 'Malanje', 'Namibe', 'Huambo', 'Soyo', 'Saurimo']
            ],
            'Portugal' => [
                'code' => 'PT',
                'cities' => ['Lisboa', 'Porto', 'Faro', 'Braga', 'Coimbra', 'Setúbal', 'Aveiro', 'Évora', 'Funchal', 'Cascais', 'Sintra']
            ],
            'África do Sul' => [
                'code' => 'ZA',
                'cities' => ['Pretória', 'Joanesburgo', 'Cidade do Cabo', 'Durban', 'East London', 'Bloemfontein', 'Port Elizabeth']
            ],
            'Brasil' => [
                'code' => 'BR',
                'cities' => ['São Paulo', 'Rio de Janeiro', 'Brasília', 'Salvador', 'Fortaleza', 'Belo Horizonte', 'Curitiba']
            ],
            'Estados Unidos' => [
                'code' => 'US',
                'cities' => ['Miami', 'Nova Iorque', 'Orlando', 'Los Angeles', 'Houston']
            ],
            'Espanha' => [
                'code' => 'ES',
                'cities' => ['Madrid', 'Barcelona', 'Valência', 'Sevilha', 'Málaga']
            ],
            'França' => [
                'code' => 'FR',
                'cities' => ['Paris', 'Marselha', 'Lyon', 'Nice', 'Bordéus']
            ],
        ];

        foreach ($data as $countryName => $info) {
            $country = Country::firstOrCreate(
                ['name' => $countryName],
                ['code' => $info['code'] ?? null, 'is_active' => true]
            );

            foreach ($info['cities'] as $cityName) {
                City::firstOrCreate(
                    ['country_id' => $country->id, 'name' => $cityName],
                    ['is_active' => true]
                );
            }
        }

        // Também garantir que quaisquer países/cidades já presentes nos imóveis sejam registados
        $existingProps = Property::all();
        foreach ($existingProps as $prop) {
            if (!empty($prop->country)) {
                $country = Country::firstOrCreate(
                    ['name' => trim($prop->country)],
                    ['is_active' => true]
                );

                if (!empty($prop->city)) {
                    City::firstOrCreate(
                        ['country_id' => $country->id, 'name' => trim($prop->city)],
                        ['is_active' => true]
                    );
                }
            }
        }

        Country::clearLocationCache();
    }
}
