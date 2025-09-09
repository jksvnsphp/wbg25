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
        Schema::create('shipping_rate_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_rate_id')->constrained('shipping_rate_tables')->onDelete('cascade');
            $table->string('shipping_service')->nullable();
            $table->decimal('cost',10,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rate_costs');
    }
};
