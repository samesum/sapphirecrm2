<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offlinePayment extends Model
{
    use HasFactory;
    protected $table    = 'offline_payments';
    protected $fillable = [
        'user_id',
        'item_type',
        'items',
        'total_amount',
        'payment_purpose',
        'phone_no',
        'bank_no',
        'doc',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function invoice(){
        return $this->belongsTo(Payment_purpose::class, 'payment_purpose', 'id');
    }
    public function item(){
        return $this->belongsTo(Invoice::class, 'items', 'id');
    }
}
