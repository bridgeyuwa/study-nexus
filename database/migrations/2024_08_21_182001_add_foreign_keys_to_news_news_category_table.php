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
        Schema::table('news_news_category', function (Blueprint $table) {
            $table->foreign(['news_id'])->references(['id'])->on('news')->cascadeOnUpdate();
			
			$table->foreign(['news_category_id'])->references(['id'])->on('news_categories')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_news_category', function (Blueprint $table) {
           $table->dropForeign('news_news_category_news_id_foreign');
		   $table->dropForeign('news_news_category_news_category_id_foreign');
        });
    }
};
