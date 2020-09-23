<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;
    
    protected $fillable = ['id','name','beds'];

    public function room(){
        return $this->belongsTo(Room::class);
    }
}
