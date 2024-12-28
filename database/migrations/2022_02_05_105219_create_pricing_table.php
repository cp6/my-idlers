<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricingTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('pricings', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->char('service_id', 8)->unique();
            $table->tinyInteger('service_type');
            $table->tinyInteger('active')->default(1);
            $table->char('currency', 3);
            $table->decimal('price', 10, 2);
            $table->tinyInteger('term');
            $table->decimal('as_usd', 10, 2);
            $table->decimal('usd_per_month', 10, 2);
            $table->date('next_due_date');
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
        Schema::dropIfExists('pricings');
    }
}
