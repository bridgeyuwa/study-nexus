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
        Schema::table('institution_types', function (Blueprint $table) {
            
			$table->foreign(['institution_type_category_id'])->references(['id'])->on('institution_type_categories')->onUpdate('cascade');
            
			
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('institution_types', function (Blueprint $table) {
            $table->dropForeign('institution_types_institution_type_category_id_foreign');
            
        });
    }
};
