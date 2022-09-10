<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperLoad extends Model
{
    use HasFactory;
    protected $filable = [
        'trade_type',
        'trade_id',
        'master_load_id',
        'exchange_id',
        'receive_address',
        'sending_address',
        'amount',
    ];
}
