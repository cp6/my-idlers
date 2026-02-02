<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResellerSeeder extends Seeder
{
    public function run()
    {
        $reseller = [];
        $pricing = [];

        // Reseller 1: Small Agency Reseller
        $id1 = Str::random(8);
        $reseller[] = [
            'id' => $id1,
            'active' => 1,
            'accounts' => 15,
            'main_domain' => 'reseller-agency.example.com',
            'reseller_type' => 'WHM/cPanel',
            'bandwidth' => null,
            'disk' => 100,
            'disk_type' => 'GB',
            'disk_as_gb' => 100,
            'domains_limit' => 50,
            'subdomains_limit' => null,
            'ftp_limit' => null,
            'email_limit' => null,
            'db_limit' => null,
            'provider_id' => 35,
            'location_id' => 19,
            'was_promo' => 0,
            'owned_since' => Carbon::now()->subMonths(24)->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id1,
            'service_type' => 3,
            'currency' => 'USD',
            'price' => 299.88,
            'term' => 4,
            'as_usd' => 299.88,
            'usd_per_month' => 24.99,
            'next_due_date' => Carbon::now()->addDays(90)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Reseller 2: Web Design Business
        $id2 = Str::random(8);
        $reseller[] = [
            'id' => $id2,
            'active' => 1,
            'accounts' => 45,
            'main_domain' => 'webdesign-hosting.example.com',
            'reseller_type' => 'WHM/cPanel',
            'bandwidth' => null,
            'disk' => 250,
            'disk_type' => 'GB',
            'disk_as_gb' => 250,
            'domains_limit' => null,
            'subdomains_limit' => null,
            'ftp_limit' => null,
            'email_limit' => null,
            'db_limit' => null,
            'provider_id' => 80,
            'location_id' => 17,
            'was_promo' => 1,
            'owned_since' => Carbon::now()->subMonths(36)->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id2,
            'service_type' => 3,
            'currency' => 'USD',
            'price' => 599.88,
            'term' => 4,
            'as_usd' => 599.88,
            'usd_per_month' => 49.99,
            'next_due_date' => Carbon::now()->addDays(150)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Reseller 3: Freelancer Starter
        $id3 = Str::random(8);
        $reseller[] = [
            'id' => $id3,
            'active' => 1,
            'accounts' => 5,
            'main_domain' => 'freelance-host.example.com',
            'reseller_type' => 'DirectAdmin',
            'bandwidth' => 5000,
            'disk' => 50,
            'disk_type' => 'GB',
            'disk_as_gb' => 50,
            'domains_limit' => 25,
            'subdomains_limit' => 50,
            'ftp_limit' => 25,
            'email_limit' => 100,
            'db_limit' => 25,
            'provider_id' => 39,
            'location_id' => 3,
            'was_promo' => 0,
            'owned_since' => Carbon::now()->subMonths(6)->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id3,
            'service_type' => 3,
            'currency' => 'EUR',
            'price' => 107.88,
            'term' => 4,
            'as_usd' => 117.00,
            'usd_per_month' => 9.75,
            'next_due_date' => Carbon::now()->addDays(200)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Reseller 4: Enterprise Reseller
        $id4 = Str::random(8);
        $reseller[] = [
            'id' => $id4,
            'active' => 1,
            'accounts' => 120,
            'main_domain' => 'enterprise-reseller.example.com',
            'reseller_type' => 'WHM/cPanel',
            'bandwidth' => null,
            'disk' => 500,
            'disk_type' => 'GB',
            'disk_as_gb' => 500,
            'domains_limit' => null,
            'subdomains_limit' => null,
            'ftp_limit' => null,
            'email_limit' => null,
            'db_limit' => null,
            'provider_id' => 58,
            'location_id' => 51,
            'was_promo' => 0,
            'owned_since' => Carbon::now()->subMonths(48)->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id4,
            'service_type' => 3,
            'currency' => 'USD',
            'price' => 1199.88,
            'term' => 4,
            'as_usd' => 1199.88,
            'usd_per_month' => 99.99,
            'next_due_date' => Carbon::now()->addDays(30)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Reseller 5: Inactive Old Reseller
        $id5 = Str::random(8);
        $reseller[] = [
            'id' => $id5,
            'active' => 0,
            'accounts' => 8,
            'main_domain' => 'old-reseller.example.com',
            'reseller_type' => 'Plesk',
            'bandwidth' => 10000,
            'disk' => 75,
            'disk_type' => 'GB',
            'disk_as_gb' => 75,
            'domains_limit' => 30,
            'subdomains_limit' => 60,
            'ftp_limit' => 30,
            'email_limit' => 150,
            'db_limit' => 30,
            'provider_id' => 29,
            'location_id' => 58,
            'was_promo' => 1,
            'owned_since' => Carbon::now()->subMonths(60)->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id5,
            'service_type' => 3,
            'currency' => 'USD',
            'price' => 179.88,
            'term' => 4,
            'as_usd' => 179.88,
            'usd_per_month' => 14.99,
            'next_due_date' => Carbon::now()->subDays(90)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Insert pricing FIRST due to foreign key constraint
        DB::table('pricings')->insert($pricing);
        DB::table('reseller_hosting')->insert($reseller);
    }
}
