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
        Schema::create('accreditation_statuses', function (Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->string('class'); //full => success, interim => warning, denied => danger
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accreditation_statuses');
    }
};
