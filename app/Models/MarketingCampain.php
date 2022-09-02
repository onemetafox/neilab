<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingCampain extends Model
{
    use HasFactory;
    protected $fillable = [
        'campain_name',
        'total_fee',
        'internal_sales_fee',
        'uni_level_fee',
        'external_sales_fee',
        'trust_fee',
        'profit_fee',
        'kyc_required',
        'domain_id',
        'status',
    ];
}
