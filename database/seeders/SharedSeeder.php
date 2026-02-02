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
        $shared = [];
        $pricing = [];

        // Shared 1: Personal Blog Hosting
        $id1 = Str::random(8);
        $shared[] = [
            'id' => $id1,
            'active' => 1,
            'main_domain' => 'myblog.example.com',
            'shared_type' => 'cPanel',
            'bandwidth' => null,
            'disk' => 10,
            'disk_type' => 'GB',
            'disk_as_gb' => 10,
            'domains_limit' => 1,
            'subdomains_limit' => 5,
            'ftp_limit' => 2,
            'email_limit' => 5,
            'db_limit' => 2,
            'provider_id' => 6,
            'location_id' => 17,
            'was_promo' => 0,
            'owned_since' => Carbon::now()->subMonths(18)->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id1,
            'service_type' => 2,
            'currency' => 'USD',
            'price' => 35.88,
            'term' => 4,
            'as_usd' => 35.88,
            'usd_per_month' => 2.99,
            'next_due_date' => Carbon::now()->addDays(45)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Shared 2: Business Website
        $id2 = Str::random(8);
        $shared[] = [
            'id' => $id2,
            'active' => 1,
            'main_domain' => 'business-site.example.com',
            'shared_type' => 'cPanel',
            'bandwidth' => null,
            'disk' => 50,
            'disk_type' => 'GB',
            'disk_as_gb' => 50,
            'domains_limit' => 10,
            'subdomains_limit' => 25,
            'ftp_limit' => 10,
            'email_limit' => 100,
            'db_limit' => 10,
            'provider_id' => 35,
            'location_id' => 27,
            'was_promo' => 1,
            'owned_since' => Carbon::now()->subMonths(24)->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id2,
            'service_type' => 2,
            'currency' => 'USD',
            'price' => 107.88,
            'term' => 4,
            'as_usd' => 107.88,
            'usd_per_month' => 8.99,
            'next_due_date' => Carbon::now()->addDays(120)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Shared 3: Portfolio Site
        $id3 = Str::random(8);
        $shared[] = [
            'id' => $id3,
            'active' => 1,
            'main_domain' => 'portfolio.example.com',
            'shared_type' => 'DirectAdmin',
            'bandwidth' => 2000,
            'disk' => 20,
            'disk_type' => 'GB',
            'disk_as_gb' => 20,
            'domains_limit' => 3,
            'subdomains_limit' => 10,
            'ftp_limit' => 5,
            'email_limit' => 10,
            'db_limit' => 5,
            'provider_id' => 39,
            'location_id' => 35,
            'was_promo' => 0,
            'owned_since' => Carbon::now()->subMonths(6)->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id3,
            'service_type' => 2,
            'currency' => 'EUR',
            'price' => 47.88,
            'term' => 4,
            'as_usd' => 52.00,
            'usd_per_month' => 4.33,
            'next_due_date' => Carbon::now()->addDays(180)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Shared 4: E-commerce Store
        $id4 = Str::random(8);
        $shared[] = [
            'id' => $id4,
            'active' => 1,
            'main_domain' => 'shop.example.com',
            'shared_type' => 'cPanel',
            'bandwidth' => null,
            'disk' => 100,
            'disk_type' => 'GB',
            'disk_as_gb' => 100,
            'domains_limit' => null,
            'subdomains_limit' => null,
            'ftp_limit' => null,
            'email_limit' => null,
            'db_limit' => null,
            'provider_id' => 20,
            'location_id' => 36,
            'was_promo' => 0,
            'owned_since' => Carbon::now()->subMonths(12)->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id4,
            'service_type' => 2,
            'currency' => 'USD',
            'price' => 191.88,
            'term' => 4,
            'as_usd' => 191.88,
            'usd_per_month' => 15.99,
            'next_due_date' => Carbon::now()->addDays(60)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Shared 5: WordPress Managed (Inactive)
        $id5 = Str::random(8);
        $shared[] = [
            'id' => $id5,
            'active' => 0,
            'main_domain' => 'old-wordpress.example.com',
            'shared_type' => 'Plesk',
            'bandwidth' => 5000,
            'disk' => 30,
            'disk_type' => 'GB',
            'disk_as_gb' => 30,
            'domains_limit' => 5,
            'subdomains_limit' => 15,
            'ftp_limit' => 5,
            'email_limit' => 25,
            'db_limit' => 5,
            'provider_id' => 29,
            'location_id' => 58,
            'was_promo' => 1,
            'owned_since' => Carbon::now()->subMonths(36)->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id5,
            'service_type' => 2,
            'currency' => 'USD',
            'price' => 143.88,
            'term' => 4,
            'as_usd' => 143.88,
            'usd_per_month' => 11.99,
            'next_due_date' => Carbon::now()->subDays(60)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Shared 6: Agency Multi-site
        $id6 = Str::random(8);
        $shared[] = [
            'id' => $id6,
            'active' => 1,
            'main_domain' => 'agency-clients.example.com',
            'shared_type' => 'cPanel',
            'bandwidth' => null,
            'disk' => 200,
            'disk_type' => 'GB',
            'disk_as_gb' => 200,
            'domains_limit' => null,
            'subdomains_limit' => null,
            'ftp_limit' => null,
            'email_limit' => null,
            'db_limit' => null,
            'provider_id' => 12,
            'location_id' => 51,
            'was_promo' => 0,
            'owned_since' => Carbon::now()->subMonths(8)->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id6,
            'service_type' => 2,
            'currency' => 'USD',
            'price' => 50.00,
            'term' => 1,
            'as_usd' => 50.00,
            'usd_per_month' => 50.00,
            'next_due_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Insert pricing FIRST due to foreign key constraint
        DB::table('pricings')->insert($pricing);
        DB::table('shared_hosting')->insert($shared);
    }
}
