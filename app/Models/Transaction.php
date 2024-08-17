<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_order',
        'id_user',
        'id_post',
        'id_category',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
}
