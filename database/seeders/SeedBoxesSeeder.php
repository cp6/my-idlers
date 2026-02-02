<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeedBoxesSeeder extends Seeder
{
    public function run()
    {
        $seedboxes = [];
        $pricing = [];

        // Seedbox 1
        $id1 = Str::random(8);
        $seedboxes[] = [
            'id' => $id1,
            'active' => 1,
            'title' => 'Plex Media Server',
            'hostname' => 'plex.seedbox.example.com',
            'seed_box_type' => 'Dedicated',
            'provider_id' => 69,
            'location_id' => 3,
            'bandwidth' => 0,
            'port_speed' => 1000,
            'disk' => 4000,
            'disk_type' => 'GB',
            'disk_as_gb' => 4000,
            'was_promo' => 0,
            'owned_since' => Carbon::now()->subMonths(12)->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id1,
            'service_type' => 6,
            'currency' => 'EUR',
            'price' => 25.00,
            'term' => 1,
            'as_usd' => 27.00,
            'usd_per_month' => 27.00,
            'next_due_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Seedbox 2
        $id2 = Str::random(8);
        $seedboxes[] = [
            'id' => $id2,
            'active' => 1,
            'title' => 'Torrent Box Pro',
            'hostname' => 'torrent.seedbox.example.com',
            'seed_box_type' => 'Shared',
            'provider_id' => 32,
            'location_id' => 23,
            'bandwidth' => 10000,
            'port_speed' => 10000,
            'disk' => 2000,
            'disk_type' => 'GB',
            'disk_as_gb' => 2000,
            'was_promo' => 1,
            'owned_since' => Carbon::now()->subMonths(6)->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id2,
            'service_type' => 6,
            'currency' => 'EUR',
            'price' => 15.00,
            'term' => 1,
            'as_usd' => 16.25,
            'usd_per_month' => 16.25,
            'next_due_date' => Carbon::now()->addDays(12)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Seedbox 3
        $id3 = Str::random(8);
        $seedboxes[] = [
            'id' => $id3,
            'active' => 1,
            'title' => 'Racing Seedbox',
            'hostname' => 'race.seedbox.example.com',
            'seed_box_type' => 'Dedicated',
            'provider_id' => 69,
            'location_id' => 56,
            'bandwidth' => 0,
            'port_speed' => 10000,
            'disk' => 8000,
            'disk_type' => 'GB',
            'disk_as_gb' => 8000,
            'was_promo' => 0,
            'owned_since' => Carbon::now()->subMonths(3)->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id3,
            'service_type' => 6,
            'currency' => 'EUR',
            'price' => 45.00,
            'term' => 1,
            'as_usd' => 48.75,
            'usd_per_month' => 48.75,
            'next_due_date' => Carbon::now()->addDays(20)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Insert pricing FIRST due to foreign key constraint
        DB::table('pricings')->insert($pricing);
        DB::table('seedboxes')->insert($seedboxes);
    }
}
