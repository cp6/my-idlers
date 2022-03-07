<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIPsTable extends Migration
{
    public function up()
    {
        Schema::create('ips', function (Blueprint $table) {
            $table->char('id', 8)->primary();
            $table->char('service_id', 8);
            $table->string('address');
            $table->tinyInteger('is_ipv4')->default(1);
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
            $table->unique(['service_id','address'], 'ips_u1');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ips');
    }
}
