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
        Schema::table('religious_affiliations', function (Blueprint $table) {
            
			$table->foreign(['religious_affiliation_category_id'])->references(['id'])->on('religious_affiliation_categories')->onUpdate('cascade');
            
			
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('religious_affiliations', function (Blueprint $table) {
            
			$table->dropForeign('religious_affiliations_religious_affiliation_category_id_foreign');
            
			
        });
    }
};
