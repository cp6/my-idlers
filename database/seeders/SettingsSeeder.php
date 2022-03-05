<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
<<<<<<< HEAD
    /**
     * Run the database seeds.
     *
     * @return void
     */
=======
>>>>>>> 972edfc66e6862c09c39b21902d4856409aa6157
    public function run()
    {
        $settings = [
            [
                "show_versions_footer" => 1,
                "show_servers_public" => 0,
                "show_server_value_ip" => 0,
                "show_server_value_hostname" => 0,
                "show_server_value_provider" => 1,
                "show_server_value_location" => 1,
                "show_server_value_price" => 1,
                "show_server_value_yabs" => 1,
                "created_at" => Carbon::now()
            ]
        ];

        DB::table('settings')->insert($settings);
    }
}
