<?php

use App\Models\Chart\MAR\Dose;

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
        Schema::create('doses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('patient')->index();
            $table->uuid('order')->index();
            $table->enum('status', Dose::$status_index)->default('due');
            $table->uuid('status_by')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doses');
    }
};
