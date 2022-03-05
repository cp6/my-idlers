<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetworkSpeedTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('network_speed', function (Blueprint $table) {
            $table->char('id', 8);
            $table->char('server_id', 8);
            $table->string('location');
            $table->float('send');
            $table->char('send_type', 4);
            $table->float('send_as_mbps');
            $table->float('receive');
            $table->char('receive_type', 4);
            $table->float('receive_as_mbps');
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
        Schema::dropIfExists('network_speed');
    }
}
