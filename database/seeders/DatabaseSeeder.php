<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@my-kirei.com',
            'username' => 'administrator',
            'password' => Hash::make('password'),
            'outlet_id' => 0,
        ]);

        User::factory(10)->create();
        Outlet::factory(5)->create();
        Menu::factory(25)->create();
    }
}
