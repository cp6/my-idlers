<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->char('id', 8)->unique()->default(null);
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('show_public')->default(0);
            $table->string('hostname');
            $table->string('ns1')->nullable()->default(null);
            $table->string('ns2')->nullable()->default(null);
            $table->tinyInteger('server_type')->default(1);
            $table->integer('os_id')->default(0);
            $table->integer('provider_id')->default(9999);
            $table->integer('location_id')->default(9999);
            $table->integer('ssh')->nullable()->default(22);
            $table->integer('bandwidth')->nullable();
            $table->integer('ram')->default(1024);
            $table->char('ram_type',2)->default('MB');
            $table->integer('ram_as_mb')->default(0);
            $table->integer('disk')->default(10);
            $table->char('disk_type',2)->default('GB');
            $table->integer('disk_as_gb')->default(0);
            $table->integer('cpu')->default(1);
            $table->tinyInteger('has_yabs')->default(0);
            $table->tinyInteger('was_promo')->default(0);
            $table->date('owned_since')->nullable();
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
        Schema::dropIfExists('servers');
    }
}
