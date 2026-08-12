<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Property;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
        });

        // Generate slugs for all existing properties
        Property::all()->each(function (Property $property) {
            $base = Str::slug($property->title);
            $slug = $base;
            $i    = 1;

            while (Property::where('slug', $slug)->where('id', '!=', $property->id)->exists()) {
                $slug = $base . '-' . $i++;
            }

            $property->timestamps = false; // don't update updated_at
            $property->update(['slug' => $slug]);
        });

        // Make slug non-nullable after backfilling
        Schema::table('properties', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
