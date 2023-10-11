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

    public function reservations()
    {
    return $this->hasMany(Reservation::class);
    }

    public function likes()
    {
    return $this->hasMany(Like::class);
    }

    public function users()
    {
    return $this->hasMany(User::class);
    }

    //いいねされているかを判定するメソッド。
    public function isLikedBy($user_id): bool
    {
    // この店舗をお気に入り登録しているかを判定
    return $this->likes->contains('user_id', $user_id);
    }

    //検索用
    public function scopeShopsSearch($query, $area_id=null, $genre_id=null,  $keyword=null)
    {
        if($area_id){
            $query->where('area_id', $area_id);
        }

        if($genre_id){
            $query->where('genre_id', $genre_id);
        }

        if($keyword){
            $query->where('name','like', '%' . $keyword . '%');
        }

        return $query;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'shop_id', 'id');
    }

    //csv upload
    public function csvHeader(): array
    {
        return [
            'id',
            'name',
            'genre_id',
            'area_id',
            'detail',
            'image',
        ];
    }

    public function getCsvData(): \Illuminate\Support\Collection
    {
        $data = DB::table('shops')->get();
        return $data;
    }
    public function insertRow($row): array
    {
        return [
            $row->name,
            $row->genre_id,
            $row->area_id,
            $row->detail,
            $row->image,
        ];
    }
}