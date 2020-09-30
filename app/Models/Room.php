<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['id','type_id'];

    public function roomType(){
        return $this->hasOne(RoomType::class,'id','type_id');
    }

    public function booking(){
        return $this->belongsTo(Booking::class,'id','room_id');
    }
}
