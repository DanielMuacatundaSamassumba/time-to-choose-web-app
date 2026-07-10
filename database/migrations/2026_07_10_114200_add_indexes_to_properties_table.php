<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Colunas mais filtradas — índices simples
            $table->index('is_active',      'idx_properties_is_active');
            $table->index('type',           'idx_properties_type');
            $table->index('property_type',  'idx_properties_property_type');
            $table->index('country',        'idx_properties_country');
            $table->index('city',           'idx_properties_city');
            $table->index('status',         'idx_properties_status');
            $table->index('bedrooms',       'idx_properties_bedrooms');
            $table->index('is_featured',    'idx_properties_is_featured');
            $table->index('created_at',     'idx_properties_created_at');

            // Índice composto para o caso mais comum: listagem activa ordenada por data
            $table->index(['is_active', 'created_at'], 'idx_properties_active_date');

            // Índice composto para filtragem por país + cidade
            $table->index(['is_active', 'country', 'city'], 'idx_properties_active_country_city');

            // Índice composto para filtragem por tipo de negócio + imóvel
            $table->index(['is_active', 'type', 'property_type'], 'idx_properties_active_type');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropIndex('idx_properties_is_active');
            $table->dropIndex('idx_properties_type');
            $table->dropIndex('idx_properties_property_type');
            $table->dropIndex('idx_properties_country');
            $table->dropIndex('idx_properties_city');
            $table->dropIndex('idx_properties_status');
            $table->dropIndex('idx_properties_bedrooms');
            $table->dropIndex('idx_properties_is_featured');
            $table->dropIndex('idx_properties_created_at');
            $table->dropIndex('idx_properties_active_date');
            $table->dropIndex('idx_properties_active_country_city');
            $table->dropIndex('idx_properties_active_type');
        });
    }
};
