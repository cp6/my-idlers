<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OsSeeder extends Seeder
{
    public function run()
    {
        $os = [
            ["name" => "None", "created_at" => Carbon::now()],
            ["name" => "AlmaLinux 8", "created_at" => Carbon::now()],
            ["name" => "AlmaLinux", "created_at" => Carbon::now()],
            ["name" => "Centos 7", "created_at" => Carbon::now()],
            ["name" => "Centos 8", "created_at" => Carbon::now()],
            ["name" => "Centos 9", "created_at" => Carbon::now()],
            ["name" => "Centos", "created_at" => Carbon::now()],
            ["name" => "Debian 9", "created_at" => Carbon::now()],
            ["name" => "Debian 10", "created_at" => Carbon::now()],
            ["name" => "Debian", "created_at" => Carbon::now()],
            ["name" => "Fedora 32", "created_at" => Carbon::now()],
            ["name" => "Fedora 33", "created_at" => Carbon::now()],
            ["name" => "Fedora 34", "created_at" => Carbon::now()],
            ["name" => "Fedora", "created_at" => Carbon::now()],
            ["name" => "FreeBSD 11.4", "created_at" => Carbon::now()],
            ["name" => "FreeBSD 12.1", "created_at" => Carbon::now()],
            ["name" => "FreeBSD", "created_at" => Carbon::now()],
            ["name" => "OpenBSD 6.7", "created_at" => Carbon::now()],
            ["name" => "OpenBSD 6.8", "created_at" => Carbon::now()],
            ["name" => "OpenBSD", "created_at" => Carbon::now()],
            ["name" => "Red Hat Enterprise Linux 8", "created_at" => Carbon::now()],
            ["name" => "Red Hat Enterprise Linux 9", "created_at" => Carbon::now()],
            ["name" => "Red Hat Enterprise Linux", "created_at" => Carbon::now()],
            ["name" => "Rocky Linux 8", "created_at" => Carbon::now()],
            ["name" => "Rocky Linux", "created_at" => Carbon::now()],
            ["name" => "Ubuntu 16.04", "created_at" => Carbon::now()],
            ["name" => "Ubuntu 18.04", "created_at" => Carbon::now()],
            ["name" => "Ubuntu 20.04", "created_at" => Carbon::now()],
            ["name" => "Ubuntu 20.10", "created_at" => Carbon::now()],
            ["name" => "Ubuntu 22.10", "created_at" => Carbon::now()],
            ["name" => "Ubuntu", "created_at" => Carbon::now()],
            ["name" => "Windows Server 2008", "created_at" => Carbon::now()],
            ["name" => "Windows Server 2012", "created_at" => Carbon::now()],
            ["name" => "Windows Server 2016", "created_at" => Carbon::now()],
            ["name" => "Windows Server 2019", "created_at" => Carbon::now()],
            ["name" => "Windows 10", "created_at" => Carbon::now()],
            ["name" => "Windows 11", "created_at" => Carbon::now()],
            ["name" => "Custom", "created_at" => Carbon::now()],
            ["name" => "Other", "created_at" => Carbon::now()]
        ];

        DB::table('os')->insert($os);

    }
}
