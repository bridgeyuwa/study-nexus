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
        Schema::create('institution_institution', function (Blueprint $table) {
			$table->id();
            $table->string('primary_institution_id');
			$table->string('related_institution_id');
            $table->timestamps();
			
			 $table->unique(['primary_institution_id', 'related_institution_id'], 'self_reference_institution_unique_index');
			
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institution_institution');
    }
};
