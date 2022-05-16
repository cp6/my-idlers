<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seedboxes', function (Blueprint $table) {
            $table->char('id', 8)->primary();
            $table->tinyInteger('active')->default(1);
            $table->string('title');
            $table->string('hostname')->nullable();
            $table->string('seed_box_type')->nullable();
            $table->unsignedBigInteger('provider_id')->default(9999);
            $table->unsignedBigInteger('location_id')->default(9999);
            $table->integer('bandwidth')->nullable();
            $table->integer('port_speed')->nullable();
            $table->integer('disk')->default(10);
            $table->char('disk_type', 2)->default('GB');
            $table->integer('disk_as_gb')->nullable()->default(0);
            $table->tinyInteger('was_promo')->default(0);
            $table->date('owned_since')->nullable();
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
        Schema::dropIfExists('seedboxes');
    }
};
