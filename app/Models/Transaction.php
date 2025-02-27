<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_account_id',
        'receiver_account_id',
        'transaction_type',
        'amount',
        'currency',
        'exchange_rate',
        'final_amount',
        'description',
    ];
}
