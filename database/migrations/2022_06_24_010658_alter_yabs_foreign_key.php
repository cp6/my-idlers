<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('disk_speed', function (Blueprint $table) {
            if (env('DB_CONNECTION') !== 'sqlite') {
                $table->dropForeign('ds_fk_yabs');
            }

            $table->foreign('id', 'ds_fk_yabs')->references('id')->on('yabs')->onDelete('cascade');
        });

        Schema::table('network_speed', function (Blueprint $table) {
            if (env('DB_CONNECTION') !== 'sqlite') {
                $table->dropForeign('ns_fk_yabs');
            }

            $table->foreign('id', 'ns_fk_yabs')->references('id')->on('yabs')->onDelete('cascade');
        });
    }
};
