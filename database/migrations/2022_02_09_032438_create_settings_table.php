<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->integer('id')->default(1)->unique();
            $table->boolean('show_versions_footer')->default(true);
            $table->boolean('show_servers_public')->default(false);
            $table->boolean('show_server_value_ip')->default(false);
            $table->boolean('show_server_value_hostname')->default(false);
            $table->boolean('show_server_value_provider')->default(true);
            $table->boolean('show_server_value_location')->default(true);
            $table->boolean('show_server_value_price')->default(true);
            $table->boolean('show_server_value_yabs')->default(true);
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
        Schema::dropIfExists('settings');
    }
};
