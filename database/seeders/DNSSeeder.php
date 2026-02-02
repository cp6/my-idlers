<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DNSSeeder extends Seeder
{
    public function run()
    {
        $dns = [
            // A Records
            [
                'id' => Str::random(8),
                'hostname' => 'example.com',
                'dns_type' => 'A',
                'address' => '195.201.100.50',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => 'www.example.com',
                'dns_type' => 'A',
                'address' => '195.201.100.50',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => 'api.example.com',
                'dns_type' => 'A',
                'address' => '172.105.50.100',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => 'mail.example.com',
                'dns_type' => 'A',
                'address' => '45.77.120.80',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => 'staging.example.com',
                'dns_type' => 'A',
                'address' => '167.99.150.25',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // AAAA Records (IPv6)
            [
                'id' => Str::random(8),
                'hostname' => 'example.com',
                'dns_type' => 'AAAA',
                'address' => '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => 'www.example.com',
                'dns_type' => 'AAAA',
                'address' => '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // MX Records
            [
                'id' => Str::random(8),
                'hostname' => 'example.com',
                'dns_type' => 'MX',
                'address' => '10 mail.example.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => 'example.com',
                'dns_type' => 'MX',
                'address' => '20 mail2.example.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => 'techblog.io',
                'dns_type' => 'MX',
                'address' => '10 aspmx.l.google.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // NS Records
            [
                'id' => Str::random(8),
                'hostname' => 'example.com',
                'dns_type' => 'NS',
                'address' => 'ns1.cloudflare.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => 'example.com',
                'dns_type' => 'NS',
                'address' => 'ns2.cloudflare.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => 'techblog.io',
                'dns_type' => 'NS',
                'address' => 'dns1.registrar-servers.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // TXT Records
            [
                'id' => Str::random(8),
                'hostname' => 'example.com',
                'dns_type' => 'TXT',
                'address' => 'v=spf1 include:_spf.google.com ~all',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => '_dmarc.example.com',
                'dns_type' => 'TXT',
                'address' => 'v=DMARC1; p=quarantine; rua=mailto:dmarc@example.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => 'google._domainkey.example.com',
                'dns_type' => 'TXT',
                'address' => 'v=DKIM1; k=rsa; p=MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQ...',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => 'example.com',
                'dns_type' => 'TXT',
                'address' => 'google-site-verification=abc123xyz789',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // CNAME Records
            [
                'id' => Str::random(8),
                'hostname' => 'cdn.example.com',
                'dns_type' => 'DNAME',
                'address' => 'example.com.cdn.cloudflare.net',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => 'blog.example.com',
                'dns_type' => 'DNAME',
                'address' => 'example.ghost.io',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => 'status.example.com',
                'dns_type' => 'DNAME',
                'address' => 'statuspage.betteruptime.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Additional A Records for subdomains
            [
                'id' => Str::random(8),
                'hostname' => 'db.example.com',
                'dns_type' => 'A',
                'address' => '51.91.200.100',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => 'monitor.example.com',
                'dns_type' => 'A',
                'address' => '65.108.90.120',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::random(8),
                'hostname' => 'backup.example.com',
                'dns_type' => 'A',
                'address' => '205.185.120.45',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('d_n_s')->insert($dns);
    }
}
