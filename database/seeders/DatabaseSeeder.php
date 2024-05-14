<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        \App\Models\User::factory(1)->create();//Disable demo first user creation
        $this->call(SettingsSeeder::class);
        $this->call(ProvidersSeeder::class);
        $this->call(LocationsSeeder::class);
        $this->call(OsSeeder::class);
        $this->call(LabelsSeeder::class);
       //$this->call(DomainsSeeder::class);
        //$this->call(ServersSeeder::class);
        //$this->call(SharedSeeder::class);
    }
}
