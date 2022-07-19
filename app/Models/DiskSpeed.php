<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiskSpeed extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'disk_speed';

    protected $fillable = ['id', 'server_id', 'd_4k', 'd_4k_type', 'd_4k_as_mbps', 'd_64k', 'd_64k_type', 'd_64k_as_mbps', 'd_512k', 'd_512k_type', 'd_512k_as_mbps', 'd_1m', 'd_1m_type', 'd_1m_as_mbps'];

    public function yabs()
    {
        return $this->belongsTo(Yabs::class, 'id', 'id');
    }
}
