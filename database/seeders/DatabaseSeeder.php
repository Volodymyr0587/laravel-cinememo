<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GenreSeeder::class,
            UserSeeder::class,
            ContentSeeder::class,
            ProfessionSeeder::class,
            RolesAndPermissionsSeeder::class,
        ]);
    }
}
