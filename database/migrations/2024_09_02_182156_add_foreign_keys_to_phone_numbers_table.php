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
        Schema::table('phone_numbers', function (Blueprint $table) {
            $table->foreign(['institution_id'])->references(['id'])->on('institutions')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phone_numbers', function (Blueprint $table) {
            $table->dropForeign('phone_numbers_institution_id_foreign');
        });
    }
};
