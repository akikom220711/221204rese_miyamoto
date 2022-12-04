<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Manager;

class ManagersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '黒川',
            'email' => 'kkk@example.com',
            'password' => \Hash::make('kkkkkkkkk'),
            'permission' => 1,
        ];
        Manager::create($param);
        $param = [
            'name' => '足立',
            'email' => 'ppp@example.com',
            'password' => \Hash::make('ppppppppp'),
            'permission' => 1,
        ];
        Manager::create($param);
    }
}
