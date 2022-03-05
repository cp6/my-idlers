<?php

namespace Database\Seeders;

<<<<<<< HEAD
=======
use Carbon\Carbon;
>>>>>>> 972edfc66e6862c09c39b21902d4856409aa6157
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OsSeeder extends Seeder
{
<<<<<<< HEAD
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
=======
    public function run()
    {
        $os = [
            ["name" => "None", "created_at" => Carbon::now()],
            ["name" => "Centos 7", "created_at" => Carbon::now()],
            ["name" => "Centos 8", "created_at" => Carbon::now()],
            ["name" => "Centos", "created_at" => Carbon::now()],
            ["name" => "Debian 9", "created_at" => Carbon::now()],
            ["name" => "Debian 10", "created_at" => Carbon::now()],
            ["name" => "Debian", "created_at" => Carbon::now()],
            ["name" => "Fedora 32", "created_at" => Carbon::now()],
            ["name" => "Fedora 33", "created_at" => Carbon::now()],
            ["name" => "Fedora", "created_at" => Carbon::now()],
            ["name" => "FreeBSD 11.4", "created_at" => Carbon::now()],
            ["name" => "FreeBSD 12.1", "created_at" => Carbon::now()],
            ["name" => "FreeBSD", "created_at" => Carbon::now()],
            ["name" => "OpenBSD 6.7", "created_at" => Carbon::now()],
            ["name" => "OpenBSD 6.8", "created_at" => Carbon::now()],
            ["name" => "OpenBSD", "created_at" => Carbon::now()],
            ["name" => "Ubuntu 16.04", "created_at" => Carbon::now()],
            ["name" => "Ubuntu 18.04", "created_at" => Carbon::now()],
            ["name" => "Ubuntu 20.04", "created_at" => Carbon::now()],
            ["name" => "Ubuntu 20.10", "created_at" => Carbon::now()],
            ["name" => "Ubuntu", "created_at" => Carbon::now()],
            ["name" => "Windows Server 2008", "created_at" => Carbon::now()],
            ["name" => "Windows Server 2012", "created_at" => Carbon::now()],
            ["name" => "Windows Server 2016", "created_at" => Carbon::now()],
            ["name" => "Windows Server 2019", "created_at" => Carbon::now()],
            ["name" => "Windows 10", "created_at" => Carbon::now()],
            ["name" => "Custom", "created_at" => Carbon::now()],
            ["name" => "Other", "created_at" => Carbon::now()]
>>>>>>> 972edfc66e6862c09c39b21902d4856409aa6157
        ];

        DB::table('os')->insert($os);

    }
}
