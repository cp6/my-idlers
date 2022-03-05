<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DNS extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['id', 'service_id', 'hostname', 'dns_type', 'address', 'server_id', 'domain_id'];

    public static $dns_types = ['A', 'AAAA', 'DNAME', 'MX', 'NS', 'SOA', 'TXT', 'URI'];
}
