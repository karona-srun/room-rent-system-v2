<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        
        $apartment_id = \App\Models\Apartment::create([
            'id' => Str::uuid(),
            'name' => 'Apartment',
            'logo' => 'apartment.png',
            'exchange_riel' => '4000',
            'water_cost' => '4000',
            'trash_cost' => '4000',
            'address' => 'ទីតាំងនៅបឹងកក់',
            'terms_and_conditions' => 'សូមបង់លុយជូនម្ចាស់ផ្ទះអោយបានមុនថ្ងៃទី 5 សូមអរគុណ!<br>លេខទូរសព្ទម្ចាស់ផ្ទះ 089 666665 / 098 226688'
        ]);

        \App\Models\User::factory()->create([
            'id' => Str::uuid(),
            'apartment_id' => $apartment_id,
            'name' => 'Karona',
            'email' => 'admin@gmail.com',
            'phone' => '086773007',
            'image' => '/img/faces/user.gif',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_active' => true,
            'last_login' => now()
        ]);
    }
}
