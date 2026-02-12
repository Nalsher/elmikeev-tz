<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Initial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('external_id')->unique();
            $table->bigInteger('nm_id')->index();
            $table->string('supplier_article')->index();
            $table->bigInteger('barcode')->index();
            $table->string('warehouse_name');
            $table->integer('quantity');
            $table->timestamps();
        });
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('g_number');
            $table->string('sale_id');
            $table->date('date');
            $table->date('last_change_date');
            $table->bigInteger('nm_id')->index();
            $table->string('supplier_article')->index();
            $table->bigInteger('barcode')->index();
            $table->string('warehouse_name');
            $table->string('region_name')->nullable();
            $table->decimal('total_price', 12, 2);
            $table->integer('discount_percent')->nullable();
            $table->decimal('for_pay', 12, 2)->nullable();
            $table->decimal('finished_price', 12, 2)->nullable();
            $table->boolean('is_supply')->default(false);
            $table->boolean('is_realization')->default(false);
            $table->boolean('is_storno')->nullable();
            $table->timestamps();
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('g_number');
            $table->timestamp('date');
            $table->timestamp('last_change_date');
            $table->bigInteger('nm_id')->index();
            $table->string('supplier_article')->index();
            $table->bigInteger('barcode')->index();
            $table->string('warehouse_name');
            $table->decimal('total_price', 12, 2)->nullable();
            $table->integer('discount_percent')->nullable();
            $table->boolean('is_cancel')->default(false);
            $table->timestamp('cancel_dt')->nullable();
            $table->timestamps();
        });
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('income_id');
            $table->date('date');
            $table->date('last_change_date');
            $table->date('date_close')->nullable();
            $table->bigInteger('nm_id')->index();
            $table->string('supplier_article')->index();
            $table->bigInteger('barcode')->index();
            $table->integer('quantity');
            $table->decimal('total_price', 12, 2)->nullable();
            $table->string('warehouse_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
