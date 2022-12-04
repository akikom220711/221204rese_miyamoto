<?php

namespace Tests\Feature;

use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\FavoritesTableSeeder;
use Database\Seeders\ManagersTableSeeder;
use Database\Seeders\RegionsTableSeeder;
use Database\Seeders\ReservesTableSeeder;
use Database\Seeders\ShopsTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\EvaluationsTableSeeder;
use App\Models\User;
use App\Models\Reserve;
use App\Models\Favorite;
use App\Http\Controllers\ShopController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopTestLoginUser extends TestCase
{
    use DatabaseMigrations;

    protected function setUp() :void
    {
        parent::setUp();

        $this->seed(UsersTableSeeder::class);
        $this->seed(ShopsTableSeeder::class);
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(FavoritesTableSeeder::class);
        $this->seed(ManagersTableSeeder::class);
        $this->seed(RegionsTableSeeder::class);
        $this->seed(ReservesTableSeeder::class);
        $this->seed(EvaluationsTableSeeder::class);
    }

    //user:user_onlyでログインしている場合
    public function test_index()
    {
        $array1 = [0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $array2 = [0,3.5,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $array3 = [0,2,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $user = User::find(1);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('home');

        $this->assertEquals($response['favorites_flag'], $array1);
        $this->assertEquals($response['evaluation_ave'], $array2);
        $this->assertEquals($response['evaluation_n'], $array3);

        $response->assertSessionHas('evaluation_ave', $array2);
        $response->assertSessionHas('evaluation_n', $array3);
    }

    public function test_detail(){
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/detail/1');

        $response->assertStatus(200);
        $response->assertViewIs('detail');
        $response->assertSee('確認する');
    }

    public function test_favorite(){
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/favorite/1/1');

        $response->assertStatus(302);
        $this->assertDatabaseHas('favorites',['user_id' => 1, 'shop_id' => 1]);
    }

    public function test_deleteFavorite(){
        Favorite::create(['user_id' => 1, 'shop_id' => 1]);

        $user = User::find(1);
        $response = $this->actingAs($user)->get('/deleteFavorite/1/1');

        $response->assertStatus(302);
        $this->assertDatabaseMissing('favorites',['user_id' => 1, 'shop_id' => 1]);
    }

    public function test_confirm(){
        $form = ['date' => '2023-01-15',
                'time' => '17:00:00',
                'number' => '5'];
        $user = User::find(1);
        $response = $this->actingAs($user)->post('/confirm/1/1', $form);

        $response->assertStatus(200);
        $response->assertViewIs('confirm');
        $response->assertSessionHas('form', $form);
    }

    public function test_reserve(){
        $form = ['date' => '2023-01-15',
                'time' => '17:00:00',
                'number' => '5'];

        $user = User::find(1);
        $response = $this->actingAs($user)
                            ->withSession(['form' => $form])
                            ->get('/reserve/1/1');

        $response->assertStatus(302);
        $this->assertDatabaseHas('reserves', 
                                    ['user_id' => '1',
                                    'shop_id' => '1',
                                    'date' => '2023-01-15',
                                    'time' => '17:00:00',
                                    'number' => '5']);
    }

    public function test_doneReserve(){
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/done');

        $response->assertStatus(200);
        $response->assertViewIs('done');
    }

    public function test_deleteReserve(){
        Reserve::create([
            'user_id' => '1',
            'shop_id' => '1',
            'date' => '2023-01-15',
            'time' => '17:00:00',
            'number' => '5'
        ]);

        $user = User::find(1);
        $response = $this->actingAs($user)->get('/deleteReserve/3');

        $response->assertStatus(302);
        $this->assertDatabaseMissing('reserves', 
                                    ['user_id' => '1',
                                    'shop_id' => '1',
                                    'date' => '2023-01-15',
                                    'time' => '17:00:00',
                                    'number' => '5']);
    }

    public function test_mypage(){
        $ave = [0,3.5,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $n = [0,2,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

        $user = User::find(1);
        $response = $this->actingAs($user)
                            ->withSession(['evaluation_ave' => $ave, 
                                            'evaluation_n' => $n])
                            ->get('/mypage');

        $response->assertStatus(200);
        $response->assertViewIs('mypage');
    }

    public function test_goToEvaluation(){
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/evaluation/1');

        $response->assertStatus(200);
        $response->assertViewIs('evaluation');
    }

    public function test_evaluation(){
        $form = ['evaluation' => 3,
                'evaluation_comment' => 'test'];

        $user = User::find(1);
        $response = $this->actingAs($user)->post('/evaluation/1', $form);

        $response->assertStatus(302);
        $this->assertDatabaseHas('evaluations', 
                                    ['user_id' => '1',
                                    'shop_id' => '4',
                                    'evaluation' => '3',
                                    'evaluation_comment' => 'test']);
    }

    public function test_search(){
        $array1 = [0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $array2 = [0,3.5,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $array3 = [0,2,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

        $user = User::find(1);
        $response = $this->actingAs($user)->get('/search?area=13&genre=1&keyword=');

        $response->assertStatus(200);
        $response->assertViewIs('home');

        $this->assertEquals(count($response['shops']), 3);

        $this->assertEquals($response['favorites_flag'], $array1);
        $this->assertEquals($response['evaluation_ave'], $array2);
        $this->assertEquals($response['evaluation_n'], $array3);
    }

    public function test_goToChangeReserve(){
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/goToChangeReserve/1');

        $response->assertStatus(200);
        $response->assertViewIs('changeReserve');
    }

    public function test_changeReserve(){
        $form = ['user_id' => '1',
                'shop_id' => '1',
                'date' => '2023-01-15',
                'time' => '17:00:00',
                'number' => '5'];

        $user = User::find(1);
        $response = $this->actingAs($user)->post('/changeReserve/1', $form);

        $response->assertStatus(302);
        $this->assertDatabaseHas('reserves', 
                                    ['user_id' => '1',
                                    'shop_id' => '1',
                                    'date' => '2023-01-15',
                                    'time' => '17:00:00',
                                    'number' => '5']);
    }
    
}
