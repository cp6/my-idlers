<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
<<<<<<< HEAD
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
=======
    public function run()
    {
        //\App\Models\User::factory(1)->create();//Disable demo first user creation
>>>>>>> 972edfc66e6862c09c39b21902d4856409aa6157
        $this->call(SettingsSeeder::class);
        $this->call(ProvidersSeeder::class);
        $this->call(LocationsSeeder::class);
        $this->call(OsSeeder::class);
        $this->call(LabelsSeeder::class);
<<<<<<< HEAD
        $this->call(DomainsSeeder::class);
        $this->call(ServersSeeder::class);
=======
       //$this->call(DomainsSeeder::class);
        //$this->call(ServersSeeder::class);
        //$this->call(SharedSeeder::class);
>>>>>>> 972edfc66e6862c09c39b21902d4856409aa6157
    }
}
