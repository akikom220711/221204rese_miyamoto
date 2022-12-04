<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserve;

class ReservesTableSeeder extends Seeder
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
            'shop_id' => '4',
            'date' => '2022/12/6',
            'time' => '17:00',
            'number' => '5',
        ];
        Reserve::create($param);
        $param = [
            'user_id' => '2',
            'shop_id' => '5',
            'date' => '2022/11/29',
            'time' => '18:00',
            'number' => '7',
        ];
        Reserve::create($param);
    }
}
