<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('yabs', function($table)
        {
            $table->integer('gb5_single')->nullable()->change();
            $table->integer('gb5_multi')->nullable()->change();
            $table->integer('gb5_id')->nullable()->change();
        });
    }
};
