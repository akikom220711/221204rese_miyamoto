<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '1',
            'shop_id' => '2',
        ];
        Favorite::create($param);
        $param = [
            'user_id' => '2',
            'shop_id' => '3',
        ];
        Favorite::create($param);
    }
}
