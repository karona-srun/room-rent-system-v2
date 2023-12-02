<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Message extends Model
{
    use HasFactory, HasUuids;

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function displayRoom($room_id)
    {
        return Room::where('id', $room_id)->pluck('name')->first();
    }
}

