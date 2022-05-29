<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDashCurrencySetting extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->char('dashboard_currency', 3)->default('USD');
        });
    }

    public function down()
    {
    }
}
