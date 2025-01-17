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
        Schema::create('news_news_category', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('news_id');
			$table->unsignedBigInteger('news_category_id');
            $table->timestamps();
			
			$table->unique(['news_id','news_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_news_category');
    }
};
