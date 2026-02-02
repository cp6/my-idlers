<?php

namespace Tests\Unit;

use App\Models\DNS;
use PHPUnit\Framework\TestCase;

class DnsModelTest extends TestCase
{
    public function test_dns_types_array_contains_expected_types()
    {
        $expectedTypes = ['A', 'AAAA', 'DNAME', 'MX', 'NS', 'SOA', 'TXT', 'URI'];
        $this->assertEquals($expectedTypes, DNS::$dns_types);
    }

    public function test_dns_types_array_has_8_elements()
    {
        $this->assertCount(8, DNS::$dns_types);
    }
}
