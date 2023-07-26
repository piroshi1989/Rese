<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

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

    public function reservations()
    {
    return $this->hasMany(Reservation::class);
    }

    public function likes()
    {
    return $this->hasMany(Like::class);
    }



        //後でViewで使う、いいねされているかを判定するメソッド。
public function isLikedBy($user_id): bool
{
    // この店舗をお気に入り登録しているかを判定
    return $this->likes->contains('user_id', $user_id);
}
}