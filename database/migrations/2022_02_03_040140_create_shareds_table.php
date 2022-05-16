<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_hosting', function (Blueprint $table) {
            $table->char('id', 8)->primary();
            $table->tinyInteger('active')->default(1);
            $table->string('main_domain');
            $table->string('shared_type')->nullable();
            $table->unsignedBigInteger('provider_id')->default(9999);
            $table->unsignedBigInteger('location_id')->default(9999);
            $table->integer('bandwidth')->nullable();
            $table->integer('disk')->default(10);
            $table->char('disk_type', 2)->default('GB');
            $table->integer('disk_as_gb')->nullable()->default(0);
            $table->integer('domains_limit')->nullable()->default(1);
            $table->integer('subdomains_limit')->nullable()->default(1);
            $table->integer('ftp_limit')->nullable()->default(1);
            $table->integer('email_limit')->nullable()->default(1);
            $table->integer('db_limit')->nullable()->default(1);
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
        Schema::dropIfExists('shared_hosting');
    }
}
