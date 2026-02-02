<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DomainsSeeder extends Seeder
{
    public function run()
    {
        $domains = [];
        $pricing = [];

        // Domain 1: Primary business domain
        $id1 = Str::random(8);
        $domains[] = [
            'id' => $id1,
            'domain' => 'mycompany',
            'extension' => 'com',
            'ns1' => 'ns1.cloudflare.com',
            'ns2' => 'ns2.cloudflare.com',
            'provider_id' => 63, // Namecheap
            'owned_since' => '2018-03-15',
            'created_at' => Carbon::now()->subYears(6),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id1,
            'service_type' => 4,
            'currency' => 'USD',
            'price' => 12.98,
            'term' => 4,
            'as_usd' => 12.98,
            'usd_per_month' => 1.08,
            'next_due_date' => Carbon::now()->addDays(45)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Domain 2: Tech blog
        $id2 = Str::random(8);
        $domains[] = [
            'id' => $id2,
            'domain' => 'techblog',
            'extension' => 'io',
            'ns1' => 'dns1.registrar-servers.com',
            'ns2' => 'dns2.registrar-servers.com',
            'provider_id' => 63, // Namecheap
            'owned_since' => '2020-06-20',
            'created_at' => Carbon::now()->subYears(4),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id2,
            'service_type' => 4,
            'currency' => 'USD',
            'price' => 32.98,
            'term' => 4,
            'as_usd' => 32.98,
            'usd_per_month' => 2.75,
            'next_due_date' => Carbon::now()->addDays(120)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Domain 3: Personal portfolio
        $id3 = Str::random(8);
        $domains[] = [
            'id' => $id3,
            'domain' => 'johndoe',
            'extension' => 'dev',
            'ns1' => 'ns1.google.com',
            'ns2' => 'ns2.google.com',
            'provider_id' => 71, // Porkbun
            'owned_since' => '2022-01-10',
            'created_at' => Carbon::now()->subYears(3),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id3,
            'service_type' => 4,
            'currency' => 'USD',
            'price' => 16.18,
            'term' => 4,
            'as_usd' => 16.18,
            'usd_per_month' => 1.35,
            'next_due_date' => Carbon::now()->addDays(200)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Domain 4: E-commerce store
        $id4 = Str::random(8);
        $domains[] = [
            'id' => $id4,
            'domain' => 'bestshop',
            'extension' => 'store',
            'ns1' => 'ns1.cloudflare.com',
            'ns2' => 'ns2.cloudflare.com',
            'provider_id' => 29, // Godaddy
            'owned_since' => '2021-11-05',
            'created_at' => Carbon::now()->subYears(3),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id4,
            'service_type' => 4,
            'currency' => 'USD',
            'price' => 19.99,
            'term' => 4,
            'as_usd' => 19.99,
            'usd_per_month' => 1.67,
            'next_due_date' => Carbon::now()->addDays(90)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Domain 5: SaaS product
        $id5 = Str::random(8);
        $domains[] = [
            'id' => $id5,
            'domain' => 'myawesomeapp',
            'extension' => 'app',
            'ns1' => 'ns-cloud-a1.googledomains.com',
            'ns2' => 'ns-cloud-a2.googledomains.com',
            'provider_id' => 29, // Godaddy
            'owned_since' => '2023-02-28',
            'created_at' => Carbon::now()->subYears(2),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id5,
            'service_type' => 4,
            'currency' => 'USD',
            'price' => 20.00,
            'term' => 4,
            'as_usd' => 20.00,
            'usd_per_month' => 1.67,
            'next_due_date' => Carbon::now()->addDays(60)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Domain 6: Country-specific domain
        $id6 = Str::random(8);
        $domains[] = [
            'id' => $id6,
            'domain' => 'myservice',
            'extension' => 'co.uk',
            'ns1' => 'ns1.hover.com',
            'ns2' => 'ns2.hover.com',
            'provider_id' => 44, // Hover
            'owned_since' => '2019-08-12',
            'created_at' => Carbon::now()->subYears(5),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id6,
            'service_type' => 4,
            'currency' => 'GBP',
            'price' => 12.99,
            'term' => 4,
            'as_usd' => 16.50,
            'usd_per_month' => 1.38,
            'next_due_date' => Carbon::now()->addDays(180)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Domain 7: Organization domain
        $id7 = Str::random(8);
        $domains[] = [
            'id' => $id7,
            'domain' => 'nonprofit',
            'extension' => 'org',
            'ns1' => 'ns1.cloudflare.com',
            'ns2' => 'ns2.cloudflare.com',
            'provider_id' => 64, // NameSilo
            'owned_since' => '2017-04-01',
            'created_at' => Carbon::now()->subYears(7),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id7,
            'service_type' => 4,
            'currency' => 'USD',
            'price' => 10.95,
            'term' => 4,
            'as_usd' => 10.95,
            'usd_per_month' => 0.91,
            'next_due_date' => Carbon::now()->addDays(30)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Domain 8: Network domain
        $id8 = Str::random(8);
        $domains[] = [
            'id' => $id8,
            'domain' => 'mynetwork',
            'extension' => 'net',
            'ns1' => 'dns1.registrar-servers.com',
            'ns2' => 'dns2.registrar-servers.com',
            'provider_id' => 63, // Namecheap
            'owned_since' => '2020-12-25',
            'created_at' => Carbon::now()->subYears(4),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id8,
            'service_type' => 4,
            'currency' => 'USD',
            'price' => 13.98,
            'term' => 4,
            'as_usd' => 13.98,
            'usd_per_month' => 1.17,
            'next_due_date' => Carbon::now()->addDays(15)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Domain 9: Premium short domain
        $id9 = Str::random(8);
        $domains[] = [
            'id' => $id9,
            'domain' => 'xyz',
            'extension' => 'ai',
            'ns1' => 'ns1.cloudflare.com',
            'ns2' => 'ns2.cloudflare.com',
            'provider_id' => 21, // Dynadot
            'owned_since' => '2024-01-15',
            'created_at' => Carbon::now()->subYears(1),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id9,
            'service_type' => 4,
            'currency' => 'USD',
            'price' => 180.00,
            'term' => 4,
            'as_usd' => 180.00,
            'usd_per_month' => 15.00,
            'next_due_date' => Carbon::now()->addDays(300)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Domain 10: Info domain
        $id10 = Str::random(8);
        $domains[] = [
            'id' => $id10,
            'domain' => 'projectinfo',
            'extension' => 'info',
            'ns1' => 'ns1.hover.com',
            'ns2' => 'ns2.hover.com',
            'provider_id' => 44, // Hover
            'owned_since' => '2022-07-20',
            'created_at' => Carbon::now()->subYears(2),
            'updated_at' => Carbon::now(),
        ];
        $pricing[] = [
            'service_id' => $id10,
            'service_type' => 4,
            'currency' => 'USD',
            'price' => 4.98,
            'term' => 4,
            'as_usd' => 4.98,
            'usd_per_month' => 0.42,
            'next_due_date' => Carbon::now()->addDays(240)->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ];

        // Insert pricing FIRST due to foreign key constraint
        DB::table('pricings')->insert($pricing);
        DB::table('domains')->insert($domains);
    }
}
