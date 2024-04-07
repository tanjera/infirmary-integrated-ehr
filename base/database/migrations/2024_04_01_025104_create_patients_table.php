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
        Schema::create('patients', function (Blueprint $table) {
            $table->uuid('id')->index();
            $table->boolean('active')->default(true);
            $table->string('name_first')->nullable();
            $table->string('name_middle')->nullable();
            $table->string('name_last')->nullable();
            $table->string('name_preferred')->nullable();
            $table->datetime('date_of_birth')->nullable();
            $table->string('medical_record_number')->unique();
            $table->enum('sex', ['unknown', 'female', 'male'])->default('unknown');
            $table->enum('gender', ['unknown', 'female', 'male', 'transgender', 'non_binary'])->default('unknown');
            $table->enum('pronouns', ['unknown', 'she_her', 'he_him', 'they_them'])->default('unknown');
            $table->enum('code_status', ['full', 'dnr', 'dnr_dni', 'palliative'])->default('full');
            $table->string('address')->nullable();
            $table->string('telephone')->nullable();
            $table->string('insurance_provider')->nullable();
            $table->string('insurance_account_number')->nullable();
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_relationship')->nullable();
            $table->string('next_of_kin_address')->nullable();
            $table->string('next_of_kin_telephone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
