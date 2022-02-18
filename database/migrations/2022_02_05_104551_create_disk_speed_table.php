<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiskSpeedTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('disk_speed', function (Blueprint $table) {
            $table->char('id', 8)->unique();
            $table->char('server_id',8);
            $table->float('d_4k');
            $table->char('d_4k_type',4);
            $table->float('d_4k_as_mbps');
            $table->float('d_64k');
            $table->char('d_64k_type',4);
            $table->float('d_64k_as_mbps');
            $table->float('d_512k');
            $table->char('d_512k_type',4);
            $table->float('d_512k_as_mbps');
            $table->float('d_1m');
            $table->char('d_1m_type',4);
            $table->float('d_1m_as_mbps');
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
        Schema::dropIfExists('disk_speed');
    }
}
