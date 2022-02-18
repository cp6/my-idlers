<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SharedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$shared = [
            [
                "id" => Str::random(8),
                "domain" => "node",
                "extension" => "ai",
                "provider_id" => 58,
                "price" => 9.99,
                "currency" => 'USD',
                "payment_term" => 4,
                "owned_since" => '2013-01-12',
                "next_due_date" => Carbon::now()->addDays(30)->format('Y-m-d')
            ]
        ];

        DB::table('shareds')->insert($shared);*/
    }
}
