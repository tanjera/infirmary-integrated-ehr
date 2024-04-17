<?php

use App\Models\Chart\Order;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('patient')->index();
            $table->uuid('ordered_by');
            $table->uuid('cosigned_by')->nullable();
            $table->boolean('cosign_complete')->default(false);
            $table->enum('status', Order::$status_index)->default('active');
            $table->uuid('status_by')->nullable();
            $table->enum('category', Order::$category_index)->default('general');
            $table->enum('method', Order::$method_index)->default('written');
            $table->enum('priority', Order::$priority_index)->default('routine');
            $table->datetime('start_time');
            $table->datetime('end_time')->nullable();

            $table->string('note')->nullable();

            $table->string('drug')->nullable();
            $table->double('dose_amount')->nullable();
            $table->enum('dose_unit', Order::$doseunits_index)->nullable();
            $table->enum('route', Order::$routes_index)->nullable();
            $table->enum('period_type', Order::$periodtypes_index)->nullable();
            $table->integer('period_amount')->nullable();
            $table->enum('period_unit', Order::$periodunits_index)->nullable();
            $table->integer('total_doses')->nullable();
            $table->string('indication')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
