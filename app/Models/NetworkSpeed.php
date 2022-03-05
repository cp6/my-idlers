<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkSpeed extends Model
{
    use HasFactory;

    protected $table = 'network_speed';

    protected $fillable = ['id', 'server_id', 'location', 'send', 'send_type', 'send_as_mbps', 'receive', 'receive_type', 'receive_as_mbps', 'created_at', 'updated_at'];
}
