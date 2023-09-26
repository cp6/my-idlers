<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('yabs', function (Blueprint $table) {
            $table->integer('gb6_single')->nullable()->default(null)->after('gb5_id');
            $table->integer('gb6_multi')->nullable()->default(null)->after('gb5_id');
            $table->integer('gb6_id')->nullable()->default(null)->after('gb5_id');
        });
    }

    public function down(): void
    {
        Schema::table('yabs', function (Blueprint $table) {
            $table->dropColumn('gb6_single');
            $table->dropColumn('gb6_multi');
            $table->dropColumn('gb6_id');
        });
    }
};
