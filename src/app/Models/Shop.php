<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ['name','genre_id', 'area_id', 'detail'];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function reservation()
    {
    return $this->hasMany(Reservation::class);
    }

    public function favorite()
    {
    return $this->hasMany(Favorite::class);
    }

    public function isLikedBy($user): bool {
        return Favorite::where('user_id', $user->id)->where('shop_id', $this->id)->first() !==null;
    }
}