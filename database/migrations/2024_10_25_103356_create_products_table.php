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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->decimal('price', 10, 2);

            $table->tinyInteger('isSetting')->default(0);

            $table->tinyInteger('isRate')->default(0);
            $table->unsignedBigInteger('rate_table_id')->nullable();
            $table->foreign('rate_table_id')->references('id')->on('shipping_rate_tables')->onDelete('set null');
            
            $table->bigInteger('parent_category_id')->nullable();
            $table->foreign('parent_category_id')->references('id')->on('parent_categories')->onDelete('set null');
            
            $table->bigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            
            $table->bigInteger('subcategory_id')->nullable();
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('set null');
            
            $table->unsignedBigInteger('childcategory_id')->nullable();
            $table->foreign('childcategory_id')->references('id')->on('endsubcategories')->onDelete('set null');


            $table->tinyInteger('isLimitedOffer')->default(0);
            $table->tinyInteger('isDailyDeal')->default(0);
            $table->tinyInteger('isBulkBuy')->default(0);
            $table->tinyInteger('isHotProduct')->default(0);
            $table->bigInteger('duration')->default(7);

            // pricing setup
            $table->tinyInteger('isPrice0')->default(0);
            $table->tinyInteger('isPrice1')->default(0);
            $table->tinyInteger('isPrice2')->default(0);
            $table->integer('qty0')->default(0);
            $table->integer('qty1')->default(0);
            $table->integer('qty2')->default(0);
            $table->decimal('price0',8,2)->default(0);
            $table->decimal('price1',8,2)->default(0);
            $table->decimal('price2',8,2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
