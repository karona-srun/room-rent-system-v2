<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RoomRent extends Model
{
    use HasFactory, HasUuids;

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
