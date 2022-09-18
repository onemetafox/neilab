<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperLoad extends Model
{
    use HasFactory;
    protected $fillable = [
        'trade_type',
        'trade_id',
        'masterload_id',
        'receive_address',
        'sending_address',
        'internal_treasury_wallet_id',
        'amount',
        'exchange_id',
    ];
}
