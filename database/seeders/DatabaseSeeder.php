<?php

namespace Database\Seeders;

use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@kantin.com',
            'password' => Hash::make('12345678'),
            'role'     =>'admin',
            'active'   => true,
        ]); 

        User::create([
            'name'     => 'Santri',
            'email'    => 'santri@kantin.com',
            'password' => Hash::make('87654321'),
            'role'     =>'santri',
            'active'   => true,
        ]);   

        User::create([
            'name'     => 'Wali',
            'email'    => 'wali@kantin.com',
            'password' => Hash::make('12341234'),
            'role'     =>'wali',
            'active'   => true,
        ]); 
        
        Product::factory(11)->create();
    }
}
