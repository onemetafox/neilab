<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubLoad extends Model
{
    use HasFactory;
    protected $fillable = [
        'trade_type',
        'trade_id',
        'superload_id',
        'exchange_id',
        'receive_address',
        'sending_address',
        'tx_id',
        'amount',
        'withdraw_order_id',
        'status',
    ];
}
