<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Misc extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'misc_services';

    protected $fillable = ['id', 'name', 'owned_since'];
}
