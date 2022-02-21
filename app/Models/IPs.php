<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPs extends Model
{
    use HasFactory;

    public $table = 'ips';

    protected $fillable = ['id', 'active', 'service_id', 'address', 'is_ipv4'];

    public $incrementing = false;
}
