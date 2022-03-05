<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domains extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['id', 'domain', 'extension', 'ns1', 'ns2', 'ns3', 'price', 'currency', 'payment_term', 'owned_since', 'provider_id', 'next_due_date'];
}
