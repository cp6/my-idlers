<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ips', function (Blueprint $table) {
            $table->string('continent')->default(null)->nullable()->after('active');
            $table->string('country')->default(null)->nullable()->after('active');
            $table->string('region')->default(null)->nullable()->after('active');
            $table->string('city')->default(null)->nullable()->after('active');
            $table->string('org')->default(null)->nullable()->after('active');
            $table->string('isp')->default(null)->nullable()->after('active');
            $table->string('asn')->default(null)->nullable()->after('active');
            $table->string('timezone_gmt')->default(null)->nullable()->after('active');
            $table->dateTime('fetched_at')->default(null)->nullable()->after('active');
        });
    }

    public function down(): void
    {
        Schema::table('ips', function (Blueprint $table) {
            $table->dropColumn(['continent', 'country', 'region', 'city', 'org', 'isp', 'asn', 'timezone_gmt', 'fetched_at']);
        });
    }
};
