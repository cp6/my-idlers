<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Pricing extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'service_type', 'currency', 'price', 'term', 'as_usd', 'usd_per_month', 'next_due_date'];

    public function convertToUSD(string $amount, string $convert_from): float
    {
        if ($convert_from === 'AUD') {
            return (0.76 * $amount);
        } elseif ($convert_from === "USD") {
            return $amount;
        } elseif ($convert_from === "GBP") {
            return (1.35 * $amount);
        } elseif ($convert_from === "EUR") {
            return (1.23 * $amount);
        } elseif ($convert_from === "NZD") {
            return (0.72 * $amount);
        } elseif ($convert_from === "JPY") {
            return (0.0097 * $amount);
        } elseif ($convert_from === "CAD") {
            return (0.78 * $amount);
        } else {
            return 1.00;
        }
    }

    public function costAsPerMonth(string $cost, int $term): float
    {
        if ($term === 1) {
            return $cost;
        } elseif ($term === 2) {
            return ($cost / 3);
        } elseif ($term === 3) {
            return ($cost / 6);
        } elseif ($term === 4) {
            return ($cost / 12);
        } elseif ($term === 5) {
            return ($cost / 24);
        } elseif ($term === 6) {
            return ($cost / 36);
        } else {
            return $cost;
        }
    }

    public function termAsMonths(int $term): int
    {
        if ($term === 1) {
            return 1;
        } elseif ($term === 2) {
            return 3;
        } elseif ($term === 3) {
            return 6;
        } elseif ($term === 4) {
            return 12;
        } elseif ($term === 5) {
            return 24;
        } elseif ($term === 6) {
            return 36;
        } else {
            return 62;
        }
    }

    public function deletePricing($id): void
    {
        DB::table('pricings')->where('service_id', '=', $id)->delete();
    }

    public function insertPricing(int $type, string $server_id, string $currency, float $price, int $term, float $as_usd, string $next_due_date, int $is_active = 1)
    {
        return self::create([
            'service_type' => $type,
            'service_id' => $server_id,
            'currency' => $currency,
            'price' => $price,
            'term' => $term,
            'as_usd' => $as_usd,
            'usd_per_month' => $this->costAsPerMonth($as_usd, $term),
            'next_due_date' => $next_due_date,
            'active' => ($is_active) ? 1 : 0
        ]);
    }

    public static function allPricing()
    {
        return Cache::remember('all_pricing', now()->addWeek(1), function () {
            return DB::table('pricings')
                ->get();
        });
    }
}
