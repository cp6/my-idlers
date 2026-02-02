<?php

namespace Tests\Unit;

use App\Models\Settings;
use PHPUnit\Framework\TestCase;

class SettingsModelTest extends TestCase
{
    public function test_order_by_process_returns_created_at_asc_for_value_1()
    {
        $result = Settings::orderByProcess(1);
        $this->assertEquals(['created_at', 'asc'], $result);
    }

    public function test_order_by_process_returns_created_at_desc_for_value_2()
    {
        $result = Settings::orderByProcess(2);
        $this->assertEquals(['created_at', 'desc'], $result);
    }

    public function test_order_by_process_returns_next_due_date_asc_for_value_3()
    {
        $result = Settings::orderByProcess(3);
        $this->assertEquals(['next_due_date', 'asc'], $result);
    }

    public function test_order_by_process_returns_next_due_date_desc_for_value_4()
    {
        $result = Settings::orderByProcess(4);
        $this->assertEquals(['next_due_date', 'desc'], $result);
    }

    public function test_order_by_process_returns_as_usd_asc_for_value_5()
    {
        $result = Settings::orderByProcess(5);
        $this->assertEquals(['as_usd', 'asc'], $result);
    }

    public function test_order_by_process_returns_as_usd_desc_for_value_6()
    {
        $result = Settings::orderByProcess(6);
        $this->assertEquals(['as_usd', 'desc'], $result);
    }

    public function test_order_by_process_returns_owned_since_asc_for_value_7()
    {
        $result = Settings::orderByProcess(7);
        $this->assertEquals(['owned_since', 'asc'], $result);
    }

    public function test_order_by_process_returns_owned_since_desc_for_value_8()
    {
        $result = Settings::orderByProcess(8);
        $this->assertEquals(['owned_since', 'desc'], $result);
    }

    public function test_order_by_process_returns_updated_at_asc_for_value_9()
    {
        $result = Settings::orderByProcess(9);
        $this->assertEquals(['updated_at', 'asc'], $result);
    }

    public function test_order_by_process_returns_updated_at_desc_for_value_10()
    {
        $result = Settings::orderByProcess(10);
        $this->assertEquals(['updated_at', 'desc'], $result);
    }

    public function test_order_by_process_returns_default_for_unknown_value()
    {
        $result = Settings::orderByProcess(99);
        $this->assertEquals(['created_at', 'desc'], $result);
    }
}
