<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('yabs', function (Blueprint $table) {
            if (env('DB_CONNECTION') !== 'sqlite') {
                $table->dropForeign('yabs_fk_servers');
            }

            $table->foreign('server_id', 'yabs_fk_servers')->references('id')->on('servers')->onDelete('cascade');
        });
    }
};
