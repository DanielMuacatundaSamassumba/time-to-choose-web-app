<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('page', 50);       // e.g. 'home', 'about', 'investors'
            $table->string('section', 80);    // e.g. 'hero', 'history', 'numbers'
            $table->string('field', 80);      // e.g. 'title', 'subtitle', 'stat_1'
            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['page', 'section', 'field']);
            $table->index('page');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};
