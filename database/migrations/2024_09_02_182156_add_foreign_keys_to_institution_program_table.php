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
        Schema::table('institution_program', function (Blueprint $table) {
            $table->foreign(['institution_id'])->references(['id'])->on('institutions')->cascadeOnUpdate();
            $table->foreign(['program_id'])->references(['id'])->on('programs')->cascadeOnUpdate();
            $table->foreign(['level_id'])->references(['id'])->on('levels')->cascadeOnUpdate();
			
			$table->foreign(['accreditation_body_id'])->references(['id'])->on('accreditation_bodies')->cascadeOnUpdate();
			$table->foreign(['accreditation_status_id'])->references(['id'])->on('accreditation_statuses')->cascadeOnUpdate();
            $table->foreign(['program_mode_id'])->references(['id'])->on('program_modes')->cascadeOnUpdate();
       
	   });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('institution_program', function (Blueprint $table) {
            $table->dropForeign('institution_program_institution_id_foreign');
            $table->dropForeign('institution_program_program_id_foreign');
            $table->dropForeign('institution_program_level_id_foreign');
			
			$table->dropForeign('institution_program_accreditation_body_id_foreign');
			$table->dropForeign('institution_program_accreditation_status_id_foreign');
			$table->dropForeign('institution_program_program_mode_id_foreign');
				
        });
    }
};
