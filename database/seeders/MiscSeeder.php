<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MiscSeeder extends Seeder
{
    public function run()
    {
        $misc = [];
        $pricing = [];

        // Misc 1: SSL Certificate
        $id1 = Str::random(8);
        $misc[] = [
            'id' => $id1,
            'name' => 'Wildcard SSL Certificate - *.example.com',
            'owned_since' => Carbon::now()->subMonths(12),
            'created_at' => Carbon::now()->subMonths(12),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id1,
            'service_type' => 6,
            'currency' => 'USD',
            'price' => 149.00,
            'term' => 4,
            'as_usd' => 149.00,
            'usd_per_month' => 12.42,
            'next_due_date' => Carbon::now()->addDays(60)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Misc 2: Email Service
        $id2 = Str::random(8);
        $misc[] = [
            'id' => $id2,
            'name' => 'Google Workspace - 10 Users',
            'owned_since' => Carbon::now()->subMonths(24),
            'created_at' => Carbon::now()->subMonths(24),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id2,
            'service_type' => 6,
            'currency' => 'USD',
            'price' => 72.00,
            'term' => 1,
            'as_usd' => 72.00,
            'usd_per_month' => 72.00,
            'next_due_date' => Carbon::now()->addDays(15)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Misc 3: CDN Service
        $id3 = Str::random(8);
        $misc[] = [
            'id' => $id3,
            'name' => 'Cloudflare Pro Plan',
            'owned_since' => Carbon::now()->subMonths(18),
            'created_at' => Carbon::now()->subMonths(18),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id3,
            'service_type' => 6,
            'currency' => 'USD',
            'price' => 20.00,
            'term' => 1,
            'as_usd' => 20.00,
            'usd_per_month' => 20.00,
            'next_due_date' => Carbon::now()->addDays(8)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Misc 4: Monitoring Service
        $id4 = Str::random(8);
        $misc[] = [
            'id' => $id4,
            'name' => 'UptimeRobot Pro - 50 Monitors',
            'owned_since' => Carbon::now()->subMonths(6),
            'created_at' => Carbon::now()->subMonths(6),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id4,
            'service_type' => 6,
            'currency' => 'USD',
            'price' => 7.00,
            'term' => 1,
            'as_usd' => 7.00,
            'usd_per_month' => 7.00,
            'next_due_date' => Carbon::now()->addDays(22)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Misc 5: Backup Service
        $id5 = Str::random(8);
        $misc[] = [
            'id' => $id5,
            'name' => 'Backblaze B2 - 500GB Storage',
            'owned_since' => Carbon::now()->subMonths(10),
            'created_at' => Carbon::now()->subMonths(10),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id5,
            'service_type' => 6,
            'currency' => 'USD',
            'price' => 2.50,
            'term' => 1,
            'as_usd' => 2.50,
            'usd_per_month' => 2.50,
            'next_due_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Misc 6: DNS Service
        $id6 = Str::random(8);
        $misc[] = [
            'id' => $id6,
            'name' => 'AWS Route 53 - Hosted Zones',
            'owned_since' => Carbon::now()->subMonths(36),
            'created_at' => Carbon::now()->subMonths(36),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id6,
            'service_type' => 6,
            'currency' => 'USD',
            'price' => 5.00,
            'term' => 1,
            'as_usd' => 5.00,
            'usd_per_month' => 5.00,
            'next_due_date' => Carbon::now()->addDays(30)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Misc 7: VPN Service
        $id7 = Str::random(8);
        $misc[] = [
            'id' => $id7,
            'name' => 'Tailscale Team - 10 Users',
            'owned_since' => Carbon::now()->subMonths(8),
            'created_at' => Carbon::now()->subMonths(8),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id7,
            'service_type' => 6,
            'currency' => 'USD',
            'price' => 60.00,
            'term' => 1,
            'as_usd' => 60.00,
            'usd_per_month' => 60.00,
            'next_due_date' => Carbon::now()->addDays(12)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Misc 8: Code Repository
        $id8 = Str::random(8);
        $misc[] = [
            'id' => $id8,
            'name' => 'GitHub Team - 5 Users',
            'owned_since' => Carbon::now()->subMonths(24),
            'created_at' => Carbon::now()->subMonths(24),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id8,
            'service_type' => 6,
            'currency' => 'USD',
            'price' => 44.00,
            'term' => 1,
            'as_usd' => 44.00,
            'usd_per_month' => 44.00,
            'next_due_date' => Carbon::now()->addDays(18)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Misc 9: CI/CD Service
        $id9 = Str::random(8);
        $misc[] = [
            'id' => $id9,
            'name' => 'CircleCI Performance Plan',
            'owned_since' => Carbon::now()->subMonths(12),
            'created_at' => Carbon::now()->subMonths(12),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id9,
            'service_type' => 6,
            'currency' => 'USD',
            'price' => 30.00,
            'term' => 1,
            'as_usd' => 30.00,
            'usd_per_month' => 30.00,
            'next_due_date' => Carbon::now()->addDays(25)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Misc 10: Error Tracking
        $id10 = Str::random(8);
        $misc[] = [
            'id' => $id10,
            'name' => 'Sentry Team Plan',
            'owned_since' => Carbon::now()->subMonths(15),
            'created_at' => Carbon::now()->subMonths(15),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id10,
            'service_type' => 6,
            'currency' => 'USD',
            'price' => 26.00,
            'term' => 1,
            'as_usd' => 26.00,
            'usd_per_month' => 26.00,
            'next_due_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Insert pricing FIRST due to foreign key constraint
        DB::table('pricings')->insert($pricing);
        DB::table('misc_services')->insert($misc);
    }
}
