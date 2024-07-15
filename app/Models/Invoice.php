<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory, HasUuids;

    protected $appends = ['room_name'];

    public function room()
    {
        return $this->belongsTo(Room::class,'room_rent_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class,'id','room_rent_id');
    } 
}
