<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Core setup seeders (always run first)
        $this->call(SettingsSeeder::class);
        $this->call(ProvidersSeeder::class);
        $this->call(LocationsSeeder::class);
        $this->call(OsSeeder::class);
        $this->call(LabelsSeeder::class);

        // User seeder
        $this->call(UsersSeeder::class);

        // Service seeders
        $this->call(ServersSeeder::class);
        $this->call(SharedSeeder::class);
        $this->call(ResellerSeeder::class);
        $this->call(DomainsSeeder::class);
        $this->call(MiscSeeder::class);
        $this->call(DNSSeeder::class);
    }
}
