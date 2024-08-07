<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Apartment extends Model
{
    use HasFactory, HasUuids;

    public function users()
    {
        return $this->belongsToMany(User::class,'apartment_users');
    }
}
