<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '佐藤',
            'email' => 'aaa@example.com',
            'email_verified_at' => '2022-11-09',
            'password' => \Hash::make('aaaaaaaaa'),
        ];
        User::create($param);
        $param = [
            'name' => '鈴木',
            'email' => 'zzz@example.com',
            'email_verified_at' => '2022-11-09',
            'password' => \Hash::make('zzzzzzzzz'),
        ];
        User::create($param);
        $param = [
            'name' => '山田',
            'email' => 'yyy@example.com',
            'email_verified_at' => '2022-11-09',
            'password' => \Hash::make('yyyyyyyyy'),
            'permission' => 2,
        ];
        User::create($param);
    }
}
