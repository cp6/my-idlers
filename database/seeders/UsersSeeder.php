<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'api_token' => Str::random(60),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()->subMonths(12),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'John Developer',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'api_token' => Str::random(60),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()->subMonths(6),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Jane Sysadmin',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'api_token' => Str::random(60),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()->subMonths(3),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
