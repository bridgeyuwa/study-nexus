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
        Schema::table('institution_institution', function (Blueprint $table) {
            
			$table->foreign(['primary_institution_id'])->references(['id'])->on('institutions')->onUpdate('cascade');
			$table->foreign(['related_institution_id'])->references(['id'])->on('institutions')->onUpdate('cascade');
        
			
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('institution_institution', function (Blueprint $table) {
            
			$table->dropForeign('institution_institution_primary_institution_id_foreign');
			$table->dropForeign('related_institution_primary_institution_id_foreign');
			
        });
    }
};
