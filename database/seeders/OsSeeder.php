<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $os = [
            ["name" => "None"],
            ["name" => "Centos 7"],
            ["name" => "Centos 8"],
            ["name" => "Centos"],
            ["name" => "Debian 9"],
            ["name" => "Debian 10"],
            ["name" => "Debian"],
            ["name" => "Fedora 32"],
            ["name" => "Fedora 33"],
            ["name" => "Fedora"],
            ["name" => "FreeBSD 11.4"],
            ["name" => "FreeBSD 12.1"],
            ["name" => "FreeBSD"],
            ["name" => "OpenBSD 6.7"],
            ["name" => "OpenBSD 6.8"],
            ["name" => "OpenBSD"],
            ["name" => "Ubuntu 16.04"],
            ["name" => "Ubuntu 18.04"],
            ["name" => "Ubuntu 20.04"],
            ["name" => "Ubuntu 20.10"],
            ["name" => "Ubuntu"],
            ["name" => "Windows Server 2008"],
            ["name" => "Windows Server 2012"],
            ["name" => "Windows Server 2016"],
            ["name" => "Windows Server 2019"],
            ["name" => "Windows 10"],
            ["name" => "Custom"],
            ["name" => "Other"]
        ];

        DB::table('os')->insert($os);

    }
}
