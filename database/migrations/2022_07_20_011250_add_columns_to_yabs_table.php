<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('yabs', function (Blueprint $table) {
            $table->string('uptime')->nullable()->default(null)->after('gb5_id');
            $table->string('distro')->nullable()->default(null)->after('gb5_id');
            $table->string('kernel')->nullable()->default(null)->after('gb5_id');
            $table->float('swap')->nullable()->default(null)->after('ram_mb');
            $table->char('swap_type', 2)->nullable()->default(null)->after('ram_mb');
            $table->float('swap_mb')->nullable()->default(null)->after('ram_mb');
        });
    }

    public function down()
    {
        Schema::table('yabs', function (Blueprint $table) {
            $table->dropColumn('uptime');
            $table->dropColumn('distro');
            $table->dropColumn('kernel');
            $table->dropColumn('swap');
            $table->dropColumn('swap_type', 2);
            $table->dropColumn('swap_mb');
        });
    }
};
