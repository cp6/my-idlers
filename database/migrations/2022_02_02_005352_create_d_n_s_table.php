<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDNSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_n_s', function (Blueprint $table) {
            $table->char('id', 8)->primary()->autoIncrement();
            $table->char('server_id', 8)->nullable();
            $table->char('domain_id', 8)->nullable();
            $table->char('shared_id', 8)->nullable();
            $table->char('reseller_id', 8)->nullable();
            $table->string('dns_type');
            $table->string('hostname');
            $table->string('address');
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
        Schema::dropIfExists('d_n_s');
    }
}
