<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYabsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('yabs', function (Blueprint $table) {
            $table->char('id', 8)->primary();
            $table->char('server_id', 8);
            $table->boolean('has_ipv6')->default(false);
            $table->boolean('aes')->default(false);
            $table->boolean('vm')->default(false);
            $table->dateTime('output_date');
            $table->tinyInteger('cpu_cores');
            $table->float('cpu_freq');
            $table->string('cpu_model');
            $table->float('ram');
            $table->char('ram_type', 2);
            $table->float('ram_mb');
            $table->float('disk');
            $table->char('disk_type', 2);
            $table->float('disk_gb');
            $table->integer('gb5_single');
            $table->integer('gb5_multi');
            $table->integer('gb5_id');
            $table->timestamps();
            $table->unique(['id','server_id'], 'uni');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yabs');
    }
}
