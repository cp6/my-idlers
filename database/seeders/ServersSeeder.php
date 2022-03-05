<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id1 = Str::random(8);
        $id2 = Str::random(8);

        $servers = [
            [
                "id" => $id1,
                "hostname" => "la.node.ai",
                "os_id" => 20,
                "provider_id" => 90,
                "location_id" => 34,
                "bandwidth" => 1000,
                "ipv4" => '127.0.0.1',
                "cpu" => 1,
                "ram" => 512,
                "ram_type" => 'MB',
                "ram_as_mb" => 512,
                "disk" => 20,
                "disk_type" => 'GB',
                "disk_as_gb" => 20,
                "owned_since" => '2018-05-14',
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "id" => $id2,
                "hostname" => "sg.node.ai",
                "os_id" => 20,
                "provider_id" => 90,
                "location_id" => 70,
                "bandwidth" => 2000,
                "ipv4" => '127.0.0.1',
                "cpu" => 1,
                "ram" => 2048,
                "ram_type" => 'MB',
                "ram_as_mb" => 2048,
                "disk" => 64,
                "disk_type" => 'GB',
                "disk_as_gb" => 64,
                "owned_since" => '2019-08-20',
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ];

        DB::table('servers')->insert($servers);

        $pricing = [
            [
                "service_id" => $id1,
                "service_type" => 1,
                "currency" => "USD",
                "price" => 5.00,
                "term" => 1,
                "as_usd" => 5.00,
                "usd_per_month" => 5.00,
                "next_due_date" => Carbon::now()->addDays(30)->format('Y-m-d'),
                "created_at" => Carbon::now()
            ],
            [
                "service_id" => $id2,
                "service_type" => 1,
                "currency" => "USD",
                "price" => 12.00,
                "term" => 1,
                "as_usd" => 12.00,
                "usd_per_month" => 12.00,
                "next_due_date" => Carbon::now()->addDays(30)->format('Y-m-d'),
                "created_at" => Carbon::now()
            ],
        ];

        DB::table('pricings')->insert($pricing);
    }
}
