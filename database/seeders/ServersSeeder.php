<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServersSeeder extends Seeder
{
    public function run()
    {
        $servers = [];
        $pricing = [];
        $ips = [];

        // Server 1: Production Web Server
        $id1 = Str::random(8);
        $servers[] = [
            'id' => $id1,
            'hostname' => 'web-prod-01.example.com',
            'server_type' => 1, // KVM
            'os_id' => 27, // Ubuntu 20.04
            'provider_id' => 32, // Hetzner
            'location_id' => 23, // Frankfurt
            'bandwidth' => 20000,
            'cpu' => 4,
            'ram' => 8192,
            'ram_type' => 'MB',
            'ram_as_mb' => 8192,
            'disk' => 160,
            'disk_type' => 'GB',
            'disk_as_gb' => 160,
            'active' => 1,
            'show_public' => 1,
            'was_promo' => 0,
            'owned_since' => '2023-01-15',
            'created_at' => Carbon::now()->subMonths(24),
            'updated_at' => Carbon::now(),
        ];

        $pricing[] = [
            'service_id' => $id1,
            'service_type' => 1,
            'currency' => 'EUR',
            'price' => 29.90,
            'term' => 1,
            'as_usd' => 32.50,
            'usd_per_month' => 32.50,
            'next_due_date' => Carbon::now()->addDays(15)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];
        $ips[] = ['id' => Str::random(8), 'service_id' => $id1, 'address' => '195.201.100.50', 'is_ipv4' => 1, 'active' => 1, 'created_at' => Carbon::now()];

        // Server 2: Database Server
        $id2 = Str::random(8);
        $servers[] = [
            'id' => $id2,
            'hostname' => 'db-master.example.com',
            'server_type' => 3, // Dedicated
            'os_id' => 27, // Ubuntu 20.04
            'provider_id' => 69, // OVH
            'location_id' => 56, // Paris
            'bandwidth' => 0, // Unlimited
            'cpu' => 8,
            'ram' => 32768,
            'ram_type' => 'MB',
            'ram_as_mb' => 32768,
            'disk' => 2000,
            'disk_type' => 'GB',
            'disk_as_gb' => 2000,
            'active' => 1,
            'show_public' => 0,
            'was_promo' => 0,
            'owned_since' => '2022-06-01',
            'created_at' => Carbon::now()->subMonths(30),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id2,
            'service_type' => 1,
            'currency' => 'EUR',
            'price' => 89.00,
            'term' => 1,
            'as_usd' => 96.50,
            'usd_per_month' => 96.50,
            'next_due_date' => Carbon::now()->addDays(22)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];
        $ips[] = ['id' => Str::random(8), 'service_id' => $id2, 'address' => '51.91.200.100', 'is_ipv4' => 1, 'active' => 1, 'created_at' => Carbon::now()];

        // Server 3: Staging Server
        $id3 = Str::random(8);
        $servers[] = [
            'id' => $id3,
            'hostname' => 'staging.example.com',
            'server_type' => 1, // KVM
            'os_id' => 42, // Ubuntu 24.04
            'provider_id' => 17, // Digital Ocean
            'location_id' => 51, // New York
            'bandwidth' => 4000,
            'cpu' => 2,
            'ram' => 4096,
            'ram_type' => 'MB',
            'ram_as_mb' => 4096,
            'disk' => 80,
            'disk_type' => 'GB',
            'disk_as_gb' => 80,
            'active' => 1,
            'show_public' => 0,
            'was_promo' => 0,
            'owned_since' => '2024-03-10',
            'created_at' => Carbon::now()->subMonths(10),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id3,
            'service_type' => 1,
            'currency' => 'USD',
            'price' => 24.00,
            'term' => 1,
            'as_usd' => 24.00,
            'usd_per_month' => 24.00,
            'next_due_date' => Carbon::now()->addDays(8)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];
        $ips[] = ['id' => Str::random(8), 'service_id' => $id3, 'address' => '167.99.150.25', 'is_ipv4' => 1, 'active' => 1, 'created_at' => Carbon::now()];

        // Server 4: Mail Server
        $id4 = Str::random(8);
        $servers[] = [
            'id' => $id4,
            'hostname' => 'mail.example.com',
            'server_type' => 1, // KVM
            'os_id' => 8, // Debian 10
            'provider_id' => 96, // Vultr
            'location_id' => 3, // Amsterdam
            'bandwidth' => 2000,
            'cpu' => 1,
            'ram' => 2048,
            'ram_type' => 'MB',
            'ram_as_mb' => 2048,
            'disk' => 55,
            'disk_type' => 'GB',
            'disk_as_gb' => 55,
            'active' => 1,
            'show_public' => 1,
            'was_promo' => 1,
            'owned_since' => '2023-08-20',
            'created_at' => Carbon::now()->subMonths(17),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id4,
            'service_type' => 1,
            'currency' => 'USD',
            'price' => 12.00,
            'term' => 1,
            'as_usd' => 12.00,
            'usd_per_month' => 12.00,
            'next_due_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];
        $ips[] = ['id' => Str::random(8), 'service_id' => $id4, 'address' => '45.77.120.80', 'is_ipv4' => 1, 'active' => 1, 'created_at' => Carbon::now()];

        // Server 5: API Gateway
        $id5 = Str::random(8);
        $servers[] = [
            'id' => $id5,
            'hostname' => 'api-gateway.example.com',
            'server_type' => 1, // KVM
            'os_id' => 42, // Ubuntu 24.04
            'provider_id' => 58, // Linode
            'location_id' => 36, // Los Angeles
            'bandwidth' => 5000,
            'cpu' => 2,
            'ram' => 4096,
            'ram_type' => 'MB',
            'ram_as_mb' => 4096,
            'disk' => 80,
            'disk_type' => 'GB',
            'disk_as_gb' => 80,
            'active' => 1,
            'show_public' => 1,
            'was_promo' => 0,
            'owned_since' => '2024-01-05',
            'created_at' => Carbon::now()->subMonths(13),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id5,
            'service_type' => 1,
            'currency' => 'USD',
            'price' => 20.00,
            'term' => 1,
            'as_usd' => 20.00,
            'usd_per_month' => 20.00,
            'next_due_date' => Carbon::now()->addDays(12)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];
        $ips[] = ['id' => Str::random(8), 'service_id' => $id5, 'address' => '172.105.50.100', 'is_ipv4' => 1, 'active' => 1, 'created_at' => Carbon::now()];

        // Server 6: Backup Server
        $id6 = Str::random(8);
        $servers[] = [
            'id' => $id6,
            'hostname' => 'backup-01.example.com',
            'server_type' => 1, // KVM
            'os_id' => 27, // Ubuntu 20.04
            'provider_id' => 8, // BuyVM
            'location_id' => 34, // Las Vegas
            'bandwidth' => 10000,
            'cpu' => 1,
            'ram' => 1024,
            'ram_type' => 'MB',
            'ram_as_mb' => 1024,
            'disk' => 1000,
            'disk_type' => 'GB',
            'disk_as_gb' => 1000,
            'active' => 1,
            'show_public' => 0,
            'was_promo' => 1,
            'owned_since' => '2022-11-15',
            'created_at' => Carbon::now()->subMonths(38),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id6,
            'service_type' => 1,
            'currency' => 'USD',
            'price' => 15.00,
            'term' => 4, // Yearly
            'as_usd' => 15.00,
            'usd_per_month' => 1.25,
            'next_due_date' => Carbon::now()->addDays(90)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];
        $ips[] = ['id' => Str::random(8), 'service_id' => $id6, 'address' => '205.185.120.45', 'is_ipv4' => 1, 'active' => 1, 'created_at' => Carbon::now()];

        // Server 7: Development Server
        $id7 = Str::random(8);
        $servers[] = [
            'id' => $id7,
            'hostname' => 'dev.example.com',
            'server_type' => 4, // LXC
            'os_id' => 42, // Ubuntu 24.04
            'provider_id' => 76, // RackNerd
            'location_id' => 36, // Los Angeles
            'bandwidth' => 3000,
            'cpu' => 2,
            'ram' => 2048,
            'ram_type' => 'MB',
            'ram_as_mb' => 2048,
            'disk' => 40,
            'disk_type' => 'GB',
            'disk_as_gb' => 40,
            'active' => 1,
            'show_public' => 0,
            'was_promo' => 1,
            'owned_since' => '2024-06-01',
            'created_at' => Carbon::now()->subMonths(8),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id7,
            'service_type' => 1,
            'currency' => 'USD',
            'price' => 21.00,
            'term' => 4, // Yearly
            'as_usd' => 21.00,
            'usd_per_month' => 1.75,
            'next_due_date' => Carbon::now()->addDays(180)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];
        $ips[] = ['id' => Str::random(8), 'service_id' => $id7, 'address' => '192.210.180.55', 'is_ipv4' => 1, 'active' => 1, 'created_at' => Carbon::now()];

        // Server 8: Monitoring Server
        $id8 = Str::random(8);
        $servers[] = [
            'id' => $id8,
            'hostname' => 'monitor.example.com',
            'server_type' => 1, // KVM
            'os_id' => 45, // Debian 11
            'provider_id' => 32, // Hetzner
            'location_id' => 25, // Helsinki
            'bandwidth' => 20000,
            'cpu' => 2,
            'ram' => 4096,
            'ram_type' => 'MB',
            'ram_as_mb' => 4096,
            'disk' => 40,
            'disk_type' => 'GB',
            'disk_as_gb' => 40,
            'active' => 1,
            'show_public' => 0,
            'was_promo' => 0,
            'owned_since' => '2024-02-20',
            'created_at' => Carbon::now()->subMonths(12),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id8,
            'service_type' => 1,
            'currency' => 'EUR',
            'price' => 5.90,
            'term' => 1,
            'as_usd' => 6.40,
            'usd_per_month' => 6.40,
            'next_due_date' => Carbon::now()->addDays(18)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];
        $ips[] = ['id' => Str::random(8), 'service_id' => $id8, 'address' => '65.108.90.120', 'is_ipv4' => 1, 'active' => 1, 'created_at' => Carbon::now()];

        // Server 9: Game Server (Inactive)
        $id9 = Str::random(8);
        $servers[] = [
            'id' => $id9,
            'hostname' => 'game-server.example.com',
            'server_type' => 3, // Dedicated
            'os_id' => 36, // Windows 10
            'provider_id' => 69, // OVH
            'location_id' => 45, // Montreal
            'bandwidth' => 0, // Unlimited
            'cpu' => 6,
            'ram' => 65536,
            'ram_type' => 'MB',
            'ram_as_mb' => 65536,
            'disk' => 500,
            'disk_type' => 'GB',
            'disk_as_gb' => 500,
            'active' => 0,
            'show_public' => 0,
            'was_promo' => 0,
            'owned_since' => '2021-12-01',
            'created_at' => Carbon::now()->subMonths(48),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id9,
            'service_type' => 1,
            'currency' => 'CAD',
            'price' => 150.00,
            'term' => 1,
            'as_usd' => 110.00,
            'usd_per_month' => 110.00,
            'next_due_date' => Carbon::now()->subDays(30)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];
        $ips[] = ['id' => Str::random(8), 'service_id' => $id9, 'address' => '158.69.200.75', 'is_ipv4' => 1, 'active' => 0, 'created_at' => Carbon::now()];

        // Server 10: CDN Edge Node
        $id10 = Str::random(8);
        $servers[] = [
            'id' => $id10,
            'hostname' => 'cdn-edge-sg.example.com',
            'server_type' => 1, // KVM
            'os_id' => 27, // Ubuntu 20.04
            'provider_id' => 96, // Vultr
            'location_id' => 72, // Singapore
            'bandwidth' => 6000,
            'cpu' => 1,
            'ram' => 1024,
            'ram_type' => 'MB',
            'ram_as_mb' => 1024,
            'disk' => 25,
            'disk_type' => 'GB',
            'disk_as_gb' => 25,
            'active' => 1,
            'show_public' => 1,
            'was_promo' => 0,
            'owned_since' => '2024-05-15',
            'created_at' => Carbon::now()->subMonths(9),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id10,
            'service_type' => 1,
            'currency' => 'USD',
            'price' => 6.00,
            'term' => 1,
            'as_usd' => 6.00,
            'usd_per_month' => 6.00,
            'next_due_date' => Carbon::now()->addDays(25)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];
        $ips[] = ['id' => Str::random(8), 'service_id' => $id10, 'address' => '139.180.200.50', 'is_ipv4' => 1, 'active' => 1, 'created_at' => Carbon::now()];

        // Insert pricing FIRST due to foreign key constraint (servers.id references pricings.service_id)
        DB::table('pricings')->insert($pricing);
        DB::table('servers')->insert($servers);
        DB::table('ips')->insert($ips);
    }
}
