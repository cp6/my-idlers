<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class Note extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'notes';

    protected $keyType = 'string';

    protected $fillable = ['id', 'service_id', 'note'];

    public static function note(string $service_id): Note
    {
        return Cache::remember("note.$service_id", now()->addMonth(1), function () use ($service_id) {
            return self::where('service_id', $service_id)->with(['server', 'shared', 'reseller', 'domain', 'dns', 'ip'])->first();
        });
    }

    public static function allNotes()
    {
        return Cache::remember("all_notes", now()->addMonth(1), function () {
            return self::with(['server', 'shared', 'reseller', 'domain', 'dns', 'ip'])->orderBy('created_at', 'desc')->get();
        });
    }

    public function server(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Server::class, 'service_id', 'id');
    }

    public function shared(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Shared::class, 'service_id', 'id');
    }

    public function reseller(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Reseller::class, 'service_id', 'id');
    }

    public function domain(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Domains::class, 'service_id', 'id');
    }

    public function dns(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DNS::class, 'service_id', 'id');
    }

    public function ip(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(IPs::class, 'service_id', 'id');
    }

}
