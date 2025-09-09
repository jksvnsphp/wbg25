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
        Schema::create('product_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('handling_time')->default(2);
            $table->mediumInteger('country_id')->nullable();
            // $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->mediumInteger('state_id')->nullable();
            // $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->string('city')->default("NA");
            $table->string('pincode')->default("NA");
            $table->tinyInteger('isReturnAccept')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_settings');
    }
};
