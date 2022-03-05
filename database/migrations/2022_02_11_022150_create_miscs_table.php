<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiscsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('misc_services', function (Blueprint $table) {
<<<<<<< HEAD
            $table->char('id', 8)->unique();
            $table->string('name');
            $table->tinyInteger('active')->default(1);
            $table->date('owned_since');
=======
            $table->char('id', 8)->primary();
            $table->string('name');
            $table->tinyInteger('active')->default(1);
            $table->date('owned_since')->nullable();
>>>>>>> 972edfc66e6862c09c39b21902d4856409aa6157
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
        Schema::dropIfExists('misc_services');
    }
<<<<<<< HEAD
};
=======
}
>>>>>>> 972edfc66e6862c09c39b21902d4856409aa6157
