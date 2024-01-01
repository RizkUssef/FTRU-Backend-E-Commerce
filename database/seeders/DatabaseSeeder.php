<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@ftru.com',
        //     'password'=>Hash::make("12345678910"),
        //     'user_type'=>"0",
        //     'country_id'=> 11,
        // ]);

        Visitor::create([
            "count"=>0
        ]);
    }
}
