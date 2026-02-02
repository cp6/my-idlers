<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class YabsSeeder extends Seeder
{
    public function run(): void
    {
        // Get server IDs that exist
        $servers = DB::table('servers')->pluck('id')->toArray();
        
        if (empty($servers)) {
            return;
        }

        $yabs = [];
        $diskSpeeds = [];
        $networkSpeeds = [];

        // YABS 1: Based on the EPYC example from yabdb.com
        $yabsId1 = Str::random(8);
        $serverId1 = $servers[0] ?? null;
        
        if ($serverId1) {
            $yabs[] = [
                'id' => $yabsId1,
                'server_id' => $serverId1,
                'has_ipv6' => 1,
                'aes' => 1,
                'vm' => 1,
                'output_date' => Carbon::now()->subDays(7)->format('Y-m-d H:i:s'),
                'cpu_cores' => 4,
                'cpu_freq' => 2300,
                'cpu_model' => 'AMD EPYC 7642 48-Core Processor',
                'ram' => 3.8,
                'ram_type' => 'GB',
                'ram_mb' => 3891,
                'disk' => 22,
                'disk_type' => 'GB',
                'disk_gb' => 22,
                'gb5_single' => null,
                'gb5_multi' => null,
                'gb5_id' => null,
                'gb6_single' => 1154,
                'gb6_multi' => 3543,
                'gb6_id' => '16379454',
                'swap' => 2,
                'swap_type' => 'MB',
                'swap_mb' => 2,
                'uptime' => '6 days, 22 hours, 17 minutes',
                'distro' => 'Debian GNU/Linux 13 (trixie)',
                'kernel' => '6.12.41+deb13-amd64',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $diskSpeeds[] = [
                'id' => $yabsId1,
                'server_id' => $serverId1,
                'd_4k' => 99,
                'd_4k_type' => 'MB/s',
                'd_4k_as_mbps' => 99,
                'd_64k' => 1.91,
                'd_64k_type' => 'GB/s',
                'd_64k_as_mbps' => 1910,
                'd_512k' => 12.71,
                'd_512k_type' => 'GB/s',
                'd_512k_as_mbps' => 12710,
                'd_1m' => 11.65,
                'd_1m_type' => 'GB/s',
                'd_1m_as_mbps' => 11650,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            // Network speeds from the example
            $networkSpeeds[] = [
                'id' => $yabsId1,
                'server_id' => $serverId1,
                'location' => 'Clouvider London, UK',
                'send' => 415,
                'send_type' => 'MBps',
                'send_as_mbps' => 415,
                'receive' => 2.48,
                'receive_type' => 'GBps',
                'receive_as_mbps' => 2480,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $networkSpeeds[] = [
                'id' => $yabsId1,
                'server_id' => $serverId1,
                'location' => 'Leaseweb NYC, NY, US',
                'send' => 1.48,
                'send_type' => 'GBps',
                'send_as_mbps' => 1480,
                'receive' => 5.00,
                'receive_type' => 'GBps',
                'receive_as_mbps' => 5000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $networkSpeeds[] = [
                'id' => $yabsId1,
                'server_id' => $serverId1,
                'location' => 'Eranium Amsterdam, NL',
                'send' => 616,
                'send_type' => 'MBps',
                'send_as_mbps' => 616,
                'receive' => 2.76,
                'receive_type' => 'GBps',
                'receive_as_mbps' => 2760,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            // Update server to has_yabs = 1
            DB::table('servers')->where('id', $serverId1)->update(['has_yabs' => 1]);
        }

        // YABS 2: A typical budget VPS
        $yabsId2 = Str::random(8);
        $serverId2 = $servers[1] ?? null;

        if ($serverId2) {
            $yabs[] = [
                'id' => $yabsId2,
                'server_id' => $serverId2,
                'has_ipv6' => 1,
                'aes' => 1,
                'vm' => 1,
                'output_date' => Carbon::now()->subDays(14)->format('Y-m-d H:i:s'),
                'cpu_cores' => 8,
                'cpu_freq' => 2100,
                'cpu_model' => 'Intel Xeon E5-2680 v4',
                'ram' => 32,
                'ram_type' => 'GB',
                'ram_mb' => 32768,
                'disk' => 2000,
                'disk_type' => 'GB',
                'disk_gb' => 2000,
                'gb5_single' => 612,
                'gb5_multi' => 3845,
                'gb5_id' => '9876543',
                'gb6_single' => 845,
                'gb6_multi' => 4521,
                'gb6_id' => '15234567',
                'swap' => 4096,
                'swap_type' => 'MB',
                'swap_mb' => 4096,
                'uptime' => '45 days, 12 hours, 33 minutes',
                'distro' => 'Ubuntu 22.04.3 LTS',
                'kernel' => '5.15.0-91-generic',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $diskSpeeds[] = [
                'id' => $yabsId2,
                'server_id' => $serverId2,
                'd_4k' => 45,
                'd_4k_type' => 'MB/s',
                'd_4k_as_mbps' => 45,
                'd_64k' => 520,
                'd_64k_type' => 'MB/s',
                'd_64k_as_mbps' => 520,
                'd_512k' => 1.2,
                'd_512k_type' => 'GB/s',
                'd_512k_as_mbps' => 1200,
                'd_1m' => 1.5,
                'd_1m_type' => 'GB/s',
                'd_1m_as_mbps' => 1500,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $networkSpeeds[] = [
                'id' => $yabsId2,
                'server_id' => $serverId2,
                'location' => 'Clouvider Paris, FR',
                'send' => 920,
                'send_type' => 'MBps',
                'send_as_mbps' => 920,
                'receive' => 940,
                'receive_type' => 'MBps',
                'receive_as_mbps' => 940,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $networkSpeeds[] = [
                'id' => $yabsId2,
                'server_id' => $serverId2,
                'location' => 'Leaseweb Frankfurt, DE',
                'send' => 890,
                'send_type' => 'MBps',
                'send_as_mbps' => 890,
                'receive' => 910,
                'receive_type' => 'MBps',
                'receive_as_mbps' => 910,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            DB::table('servers')->where('id', $serverId2)->update(['has_yabs' => 1]);
        }

        // YABS 3: High performance NVMe VPS
        $yabsId3 = Str::random(8);
        $serverId3 = $servers[2] ?? null;

        if ($serverId3) {
            $yabs[] = [
                'id' => $yabsId3,
                'server_id' => $serverId3,
                'has_ipv6' => 1,
                'aes' => 1,
                'vm' => 1,
                'output_date' => Carbon::now()->subDays(3)->format('Y-m-d H:i:s'),
                'cpu_cores' => 2,
                'cpu_freq' => 3500,
                'cpu_model' => 'AMD Ryzen 9 5950X 16-Core Processor',
                'ram' => 4,
                'ram_type' => 'GB',
                'ram_mb' => 4096,
                'disk' => 80,
                'disk_type' => 'GB',
                'disk_gb' => 80,
                'gb5_single' => 1580,
                'gb5_multi' => 2890,
                'gb5_id' => '11223344',
                'gb6_single' => 2150,
                'gb6_multi' => 3920,
                'gb6_id' => '16789012',
                'swap' => 512,
                'swap_type' => 'MB',
                'swap_mb' => 512,
                'uptime' => '12 days, 5 hours, 42 minutes',
                'distro' => 'Ubuntu 24.04 LTS',
                'kernel' => '6.8.0-45-generic',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $diskSpeeds[] = [
                'id' => $yabsId3,
                'server_id' => $serverId3,
                'd_4k' => 85,
                'd_4k_type' => 'MB/s',
                'd_4k_as_mbps' => 85,
                'd_64k' => 1.45,
                'd_64k_type' => 'GB/s',
                'd_64k_as_mbps' => 1450,
                'd_512k' => 3.2,
                'd_512k_type' => 'GB/s',
                'd_512k_as_mbps' => 3200,
                'd_1m' => 3.8,
                'd_1m_type' => 'GB/s',
                'd_1m_as_mbps' => 3800,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $networkSpeeds[] = [
                'id' => $yabsId3,
                'server_id' => $serverId3,
                'location' => 'Clouvider NYC, US',
                'send' => 2.1,
                'send_type' => 'GBps',
                'send_as_mbps' => 2100,
                'receive' => 4.5,
                'receive_type' => 'GBps',
                'receive_as_mbps' => 4500,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $networkSpeeds[] = [
                'id' => $yabsId3,
                'server_id' => $serverId3,
                'location' => 'Leaseweb LA, US',
                'send' => 1.8,
                'send_type' => 'GBps',
                'send_as_mbps' => 1800,
                'receive' => 3.2,
                'receive_type' => 'GBps',
                'receive_as_mbps' => 3200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            DB::table('servers')->where('id', $serverId3)->update(['has_yabs' => 1]);
        }

        // Insert all data
        if (!empty($yabs)) {
            DB::table('yabs')->insert($yabs);
        }
        if (!empty($diskSpeeds)) {
            DB::table('disk_speed')->insert($diskSpeeds);
        }
        if (!empty($networkSpeeds)) {
            DB::table('network_speed')->insert($networkSpeeds);
        }
    }
}
