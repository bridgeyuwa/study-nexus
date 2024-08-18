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
        Schema::table('institutions', function (Blueprint $table) {
            $table->foreign(['category_id'])->references(['id'])->on('categories')->cascadeOnUpdate();
            $table->foreign(['institution_type_id'])->references(['id'])->on('institution_types')->cascadeOnUpdate();
            $table->foreign(['state_id'])->references(['id'])->on('states')->cascadeOnUpdate();
            $table->foreign(['term_id'])->references(['id'])->on('terms')->cascadeOnUpdate();
			$table->foreign(['accreditation_body_id'])->references(['id'])->on('accreditation_bodies')->cascadeOnUpdate();
			$table->foreign(['accreditation_status_id'])->references(['id'])->on('accreditation_statuses')->cascadeOnUpdate();
			$table->foreign(['religious_affiliation_id'])->references(['id'])->on('religious_affiliations')->cascadeOnUpdate();
			$table->foreign(['institution_head_id'])->references(['id'])->on('institution_heads')->cascadeOnUpdate();
			$table->foreign(['parent_id'])->references(['id'])->on('institutions')->cascadeOnUpdate();
			
        });
    }  

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->dropForeign('institutions_category_id_foreign');
            $table->dropForeign('institutions_institution_type_id_foreign');
            $table->dropForeign('institutions_state_id_foreign');
            $table->dropForeign('institutions_term_id_foreign');
			$table->dropForeign('institutions_accreditation_body_id_foreign');
			$table->dropForeign('institutions_accreditation_status_id_foreign');
			$table->dropForeign('institutions_religious_affiliation_id_foreign');
			$table->dropForeign('institutions_institution_head_id_foreign');
			$table->dropForeign('institutions_parent_id_foreign');
			
        });
    }
};
