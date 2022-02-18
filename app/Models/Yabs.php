<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yabs extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'yabs';

    protected $fillable = ['id', 'server_id', 'has_ipv6', 'aes', 'vm', 'output_date', 'cpu_cores', 'cpu_freq', 'cpu', 'ram', 'ram_type', 'ram_mb', 'disk', 'disk_type', 'disk_gb', 'gb5_single', 'gb5_multi', 'gb5_id', '4k', '4k_type', '4k_as_mbps', '64k', '64k_type', '64k_as_mbps', '512k', '512k_type', '512k_as_mbps', '1m', '1m_type', '1m_as_mbps', 'location', 'send', 'send_type', 'send_as_mbps', 'receive', 'receive_type', 'receive_as_mbps'];
}
