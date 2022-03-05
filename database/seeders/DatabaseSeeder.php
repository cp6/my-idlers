<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();
        //\App\Models\Server::factory(10)->create();
        //\App\Models\Domains::factory(4)->create();
        $this->call(SettingsSeeder::class);
        $this->call(ProvidersSeeder::class);
        $this->call(LocationsSeeder::class);
        $this->call(OsSeeder::class);
        $this->call(LabelsSeeder::class);
        $this->call(DomainsSeeder::class);
        $this->call(ServersSeeder::class);
    }
}
