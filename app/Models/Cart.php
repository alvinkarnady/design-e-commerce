<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_post',
        'id_category',
    ];

    /**
     * The user who owns the cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * The post associated with the cart item.
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post');
    }

    /**
     * The category associated with the cart item.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
}
