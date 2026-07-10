<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('price')->nullable();           // e.g. "150.000 USD"
            $table->string('price_period')->nullable();    // e.g. "/ mês"
            $table->string('type')->default('arrendamento'); // arrendamento | venda
            $table->string('property_type')->default('apartamento'); // apartamento | vivenda | moradia | escritório | loja | terreno
            $table->string('country')->default('Angola');
            $table->string('city')->default('Luanda');
            $table->string('location')->nullable();        // Specific zone/neighborhood
            $table->unsignedTinyInteger('bedrooms')->default(0);
            $table->unsignedTinyInteger('bathrooms')->default(0);
            $table->unsignedTinyInteger('garages')->default(0);
            $table->string('area')->nullable();            // e.g. "120 m²"
            $table->string('image')->nullable();           // main image path
            $table->json('gallery')->nullable();           // array of image paths
            $table->json('amenities')->nullable();         // array of amenity strings
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('status')->default('disponivel'); // disponivel | reservado | vendido | arrendado
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
