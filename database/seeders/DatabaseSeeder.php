<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriesTableSeeder::class);
        $this->call(FavoritesTableSeeder::class);
        $this->call(ManagersTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(ReservesTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EvaluationsTableSeeder::class);
    }
}
