<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SharedSeeder extends Seeder
{
    public function run()
    {

        $id = Str::random(8);

        $shared = [
            [
                "id" => $id,
                "active" => 1,
                "main_domain" => "node.ai",
                "shared_type" => "Direct Admin",
                "bandwidth" => 3000,
                "disk" => 45,
                "disk_type" => 'GB',
                "disk_as_gb" => 45,
                "domains_limit" => 10,
                "subdomains_limit" => 10,
                "ftp_limit" => 5,
                "email_limit" => 5,
                "db_limit" => 2,
                "provider_id" => 90,
                "location_id" => 71,
                "owned_since" => Carbon::now()->subDays(220),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]
        ];

        DB::table('shared_hosting')->insert($shared);

        $pricing = [
            [
                "service_id" => $id,
                "active" => 1,
                "service_type" => 2,
                "currency" => "USD",
                "price" => 60.00,
                "term" => 4,
                "as_usd" => 60.00,
                "usd_per_month" => 5.00,
                "next_due_date" => Carbon::now()->addDays(12)->format('Y-m-d'),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]
        ];

        DB::table('pricings')->insert($pricing);
    }
}
