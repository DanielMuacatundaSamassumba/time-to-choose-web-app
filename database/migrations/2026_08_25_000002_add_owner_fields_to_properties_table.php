<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('owner_name')->nullable()->after('tour_3d_url');
            $table->string('owner_phone')->nullable()->after('owner_name');
            $table->string('owner_whatsapp')->nullable()->after('owner_phone');
            $table->string('owner_email')->nullable()->after('owner_whatsapp');
            $table->string('owner_website')->nullable()->after('owner_email');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'owner_name',
                'owner_phone',
                'owner_whatsapp',
                'owner_email',
                'owner_website',
            ]);
        });
    }
};
