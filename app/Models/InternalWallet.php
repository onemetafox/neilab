<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalWallet extends Model
{
    use HasFactory;
    protected $fillable = [
        "chain_stack",
        "login", 
        "password", 
        "ipaddress", 
        "wallet_address",
        "private_key",
        "set_as_treasury_wallet",
        "send_unpaid_commision",
        "send_trust_fee",
        "send_profit"
    ];
}
