<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scraped_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('scrape_source');
            $table->string('scrape_source_id');
            $table->string('title');
            $table->string('source');
            $table->longText('additional_data');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['scrape_source', 'scrape_source_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scraped_articles');
    }
};
