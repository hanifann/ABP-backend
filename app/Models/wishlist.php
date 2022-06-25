<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlist';
    protected $fillable = [
        'travel_id',
        'user_id',
    ];

    public function produk () {
        return $this->belongsTo('App\Models\Travel', 'travel_id');
    }
    public function user () {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
