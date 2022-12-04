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
use App\Models\Reserve;
use App\Http\Controllers\ShopController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopTestNoLogin extends TestCase
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

    //ログインなしの場合
    public function test_index(){
        $array1 = [];
        $array2 = [0,3.5,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $array3 = [0,2,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('home');

        $this->assertEquals($response['favorites_flag'], $array1);
        $this->assertEquals($response['evaluation_ave'], $array2);
        $this->assertEquals($response['evaluation_n'], $array3);

        $response->assertSessionHas('evaluation_ave', $array2);
        $response->assertSessionHas('evaluation_n', $array3);
    }

    public function test_detail(){
        $response = $this->get('/detail/1');

        $response->assertStatus(200);
        $response->assertViewIs('detail');
        $response->assertSee('ログインする');
    }

    public function test_favorite(){
        $response = $this->get('/favorite/1/1');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_deleteFavorite(){
        $response = $this->get('/deleteFavorite/1/1');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_confirm(){
        $form = ['date' => '2023-01-15',
                'time' => '17:00:00',
                'number' => '5'];

        $response = $this->post('/confirm/1/1', $form);

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_reserve(){
        $form = ['date' => '2023-01-15',
                'time' => '17:00:00',
                'number' => '5'];

        $response = $this->withSession(['form' => $form])->get('/reserve/1/1');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_doneReserve(){
        $response = $this->get('/done');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_deleteReserve(){
        Reserve::create([
            'user_id' => '1',
            'shop_id' => '1',
            'date' => '2023-01-15',
            'time' => '17:00:00',
            'number' => '5'
        ]);

        $response = $this->get('/deleteReserve/3');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_mypage(){
        $ave = [0,3.5,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $n = [0,2,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

        $response = $this->withSession(['evaluation_ave' => $ave, 'evaluation_n' => $n])->get('/mypage');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_goToEvaluation(){
        $response = $this->get('/evaluation/1');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_evaluation(){
        $form = ['evaluation' => 3,
                'evaluation_comment' => 'test'];

        $response = $this->post('/evaluation/1', $form);

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_search(){
        $array1 = [];
        $array2 = [0,3.5,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $array3 = [0,2,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

        $response = $this->get('/search?area=13&genre=1&keyword=');

        $response->assertStatus(200);
        $response->assertViewIs('home');

        $this->assertEquals(count($response['shops']), 3);

        $this->assertEquals($response['favorites_flag'], $array1);
        $this->assertEquals($response['evaluation_ave'], $array2);
        $this->assertEquals($response['evaluation_n'], $array3);
    }

    public function test_goToAdmin(){
        $response = $this->get('/admin');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_registManager(){
        $form = [
            'manager_name' => 'test',
            'manager_email' => 'test@example.com',
            'manager_password' => 'testtest',
        ];

        $response = $this->post('/admin', $form);

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_goToManage(){
        $response = $this->get('/manage');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_goToCreateShop(){
        $response = $this->get('/createShop');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_CreateShop(){
        $form = [
            'shop_name' => 'ccc',
            'comment' => 'test',
            'url' => 'テキストが入ります',
            'region_id' => '5',
            'category_id' => '3'
        ];

        $response = $this->post('/createShop/1', $form);

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_goToUpdateShop(){
        $response = $this->get('/goToUpdateShop/1/1');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_updateShop(){
        $form = [
            'shop_name' => 'ccc',
            'comment' => 'test',
            'url' => 'テキストが入ります',
            'region_id' => '5',
            'category_id' => '3'
        ];

        $response = $this->post('/updateShop/1', $form);

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_showReserve(){
        $response = $this->get('/showReserve/1');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }
}
