<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crud', function (Blueprint $table) {
            $defaultjob = 'unemployed';
            $table->id();
            $table->string('name')->nullable($value=false);
            $table->string('city')->nullable($value=false);
            $table->string('phone')->nullable($value=true);
            $table->string('job')->nullable($value=true)->default($defaultjob);
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
        Schema::dropIfExists('crud');
    }
}
