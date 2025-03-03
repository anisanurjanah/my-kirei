<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Outlet;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(3)->create();
        Outlet::factory(5)->create();
        Menu::factory(10)->create();
    }
}
