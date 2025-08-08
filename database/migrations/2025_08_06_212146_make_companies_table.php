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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('trade_name');
            $table->string('registration_number')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        // fks
        Schema::table('companies', function (Blueprint $table) {
            $table->unique(['name'], 'unique_company_name');
            $table->unique(['registration_number'], 'unique_company_registration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');

    }
};
