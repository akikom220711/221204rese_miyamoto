<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evaluation;

class EvaluationsTableSeeder extends Seeder
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
            'shop_id' => '1',
            'evaluation' => '4',
            'evaluation_comment' => 'test'
        ];
        Evaluation::create($param);
        $param = [
            'user_id' => '1',
            'shop_id' => '1',
            'evaluation' => '3',
            'evaluation_comment' => 'テキストが入ります。'
        ];
        Evaluation::create($param);
        $param = [
            'user_id' => '1',
            'shop_id' => '2',
            'evaluation' => '3',
            'evaluation_comment' => '美味しかったです。'
        ];
        Evaluation::create($param);
    }
}
