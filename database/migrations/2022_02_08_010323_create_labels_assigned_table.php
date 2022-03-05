<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelsAssignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labels_assigned', function (Blueprint $table) {
<<<<<<< HEAD
            $table->char('label_id', 8)->unique();
            $table->char('service_id', 8);
=======
            $table->char('label_id', 8);
            $table->char('service_id', 8);
            $table->unique(['label_id','service_id'], 'uni');
>>>>>>> 972edfc66e6862c09c39b21902d4856409aa6157
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labels_assigned');
    }
}
