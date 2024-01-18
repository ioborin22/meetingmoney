<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'operation_type',
        'offered_token',
        'offered_token_currency',
        'requested_token',
        'requested_token_currency',
        'amount',
        'unit_price',
        'total_price',
        'status',
        'offer_date',
        'comments',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
