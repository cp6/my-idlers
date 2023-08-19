<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Providers extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $keyType = 'string';

    protected $table = 'providers';

    public static function allProviders(): array
    {
        return Cache::remember("providers", now()->addMonth(1), function () {
            return self::orderBy('name')->get()->toArray();
        });
    }

    public static function showServicesForProvider($provider): array
    {
        $servers = DB::table('servers as s')
            ->where('s.provider_id', $provider)
            ->get(['s.id', 's.hostname'])
            ->toArray();

        $shared = DB::table('shared_hosting as s')
            ->where('s.provider_id', $provider)
            ->get(['s.id', 's.main_domain as main_domain_shared'])
            ->toArray();

        $reseller = DB::table('reseller_hosting as r')
            ->where('r.provider_id', $provider)
            ->get(['r.id', 'r.main_domain as main_domain_reseller'])
            ->toArray();

        return array_merge($servers, $shared, $reseller);
    }
}
