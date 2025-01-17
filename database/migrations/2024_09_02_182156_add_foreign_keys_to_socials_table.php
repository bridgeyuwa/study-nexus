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
        Schema::table('socials', function (Blueprint $table) {
            $table->foreign(['institution_id'])->references(['id'])->on('institutions')->cascadeOnUpdate();
            $table->foreign(['social_type_id'])->references(['id'])->on('social_types')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('socials', function (Blueprint $table) {
            $table->dropForeign('socials_institution_id_foreign');
            $table->dropForeign('socials_social_type_id_foreign');
        });
    }
};
