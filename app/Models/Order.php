<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'is_paid',
        'payment_receipt',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
