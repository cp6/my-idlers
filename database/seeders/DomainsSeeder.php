<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DomainsSeeder extends Seeder
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

        $domains = [
            [
                "id" => $id1,
                "domain" => "node",
                "extension" => "ai",
                "provider_id" => 59,
                "owned_since" => '2013-01-12'
            ],
            [
                "id" => $id2,
                "domain" => "cpu",
                "extension" => "club",
                "provider_id" => 59,
                "owned_since" => '2016-04-25'
            ]
        ];

        DB::table('domains')->insert($domains);

        $pricing = [
            [
                "service_id" => $id1,
                "service_type" => 4,
                "currency" => "USD",
                "price" => 9.99,
                "term" => 4,
                "as_usd" => 9.99,
                "usd_per_month" => 0.83,
                "next_due_date" => Carbon::now()->addDays(30)->format('Y-m-d'),
                "created_at" => Carbon::now()
            ],
            [
                "service_id" => $id2,
                "service_type" => 4,
                "currency" => "USD",
                "price" => 9.99,
                "term" => 4,
                "as_usd" => 9.99,
                "usd_per_month" => 0.83,
                "next_due_date" => Carbon::now()->addDays(30)->format('Y-m-d'),
                "created_at" => Carbon::now()
            ],
        ];

        DB::table('pricings')->insert($pricing);

    }
}
