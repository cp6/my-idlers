<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Core setup seeders (always required)
        $this->call(SettingsSeeder::class);
        $this->call(ProvidersSeeder::class);
        $this->call(LocationsSeeder::class);
        $this->call(OsSeeder::class);
        $this->call(LabelsSeeder::class);

        // Optional: Demo user and sample data
        // Run with: php artisan db:seed --class=DatabaseSeeder -- --demo
        // Or set SEED_DEMO_DATA=true in .env
        if ($this->shouldSeedDemoData()) {
            $this->call(UsersSeeder::class);
            $this->call(ServersSeeder::class);
            $this->call(SharedSeeder::class);
            $this->call(ResellerSeeder::class);
            $this->call(DomainsSeeder::class);
            $this->call(MiscSeeder::class);
            $this->call(DNSSeeder::class);
        }
    }

    private function shouldSeedDemoData(): bool
    {
        return env('SEED_DEMO_DATA', false) === true;
    }
}
