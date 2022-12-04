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
use App\Models\Manager;
use App\Models\Reserve;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageTestLoginAdmin extends TestCase
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

    //user:admin_onlyでログインしている場合
    public function test_goToAdminAsAdmin(){
        $user = User::find(3);
        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
        $response->assertViewIs('admin');
    }

    public function test_registManagerAsAdmin(){
        $form = [
            'manager_name' => 'test',
            'manager_email' => 'test@example.com',
            'manager_password' => 'testtest',
        ];

        $user = User::find(3);
        $response = $this->actingAs($user)->post('/admin', $form);

        $response->assertStatus(200);
        $response->assertViewIs('doneManagerRegist');
        $this->assertDatabaseHas('managers', [
                                    'name' => 'test',
                                    'email' => 'test@example.com',
                                    'permission' => 1]);

        $manager = Manager::find(3);
        $this->assertTrue(Hash::check('testtest', $manager->password));
    }

    public function test_goToManageAsAdmin(){
        $user = User::find(3);
        $response = $this->actingAs($user)->get('/manage');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_goToCreateShopAsAdmin(){
        $user = User::find(3);
        $response = $this->actingAs($user)->get('/createShop');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_createShopAsAdmin(){
        $form = [
            'shop_name' => 'ccc',
            'comment' => 'test',
            'url' => 'テキストが入ります',
            'region_id' => '5',
            'category_id' => '3'
        ];

        $user = User::find(3);
        $response = $this->actingAs($user)->post('/createShop/1', $form);

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_goToUpdateShopAsAdmin(){
        $user = User::find(3);
        $response = $this->actingAs($user)->get('/goToUpdateShop/1/1');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_updateShopAsAdmin(){
        $form = [
            'shop_name' => 'ccc',
            'comment' => 'test',
            'url' => 'テキストが入ります',
            'region_id' => '5',
            'category_id' => '3'
        ];

        $user = User::find(3);
        $response = $this->actingAs($user)->post('/updateShop/1', $form);

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_showReserveAsAdmin(){
        $user = User::find(3);
        $response = $this->actingAs($user)->get('/showReserve/1');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_sendMailForUserAsAdmin(){
        $form = [
            'title' => '予約のご連絡',
            'mail_address' => 'aaa@example.com',
            'mail_text' => 'ご予約ありがとうございます。'
        ];
        $email = $form['mail_address'];

        Mail::fake();

        $user = User::find(3);
        $response = $this->actingAs($user)->post('/sendMailForUser', $form);

        $response->assertStatus(302);
        Mail::assertSent(SendMail::class, 1);

        Mail::assertSent(SendMail::class, function ($mail) use ($email) {
            return $mail->hasTo($email);
        });
    }

    public function test_indexAsAdmin(){
        $array1 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $array2 = [0,3.5,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $array3 = [0,2,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

        $user = User::find(3);
        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('home');

        $this->assertEquals($response['favorites_flag'], $array1);
        $this->assertEquals($response['evaluation_ave'], $array2);
        $this->assertEquals($response['evaluation_n'], $array3);

        $response->assertSessionHas('evaluation_ave', $array2);
        $response->assertSessionHas('evaluation_n', $array3);
    }

    public function test_detailAsAdmin(){
        $user = User::find(3);
        $response = $this->actingAs($user)->get('/detail/1');

        $response->assertStatus(200);
        $response->assertViewIs('detail');
        $response->assertSee('ログインする');
    }

    public function test_searchAsAdmin(){
        $array1 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $array2 = [0,3.5,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $array3 = [0,2,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

        $user = User::find(3);
        $response = $this->actingAs($user)->get('/search?area=13&genre=1&keyword=');

        $response->assertStatus(200);
        $response->assertViewIs('home');

        $this->assertEquals(count($response['shops']), 3);

        $this->assertEquals($response['favorites_flag'], $array1);
        $this->assertEquals($response['evaluation_ave'], $array2);
        $this->assertEquals($response['evaluation_n'], $array3);
    }

    public function test_favoriteAsAdmin(){
        $user = User::find(3);
        $response = $this->actingAs($user)->get('/favorite/1/1');

        $response->assertStatus(403);
    }

    public function test_deleteFavoriteAsAdmin(){
        $user = User::find(3);
        $response = $this->actingAs($user)->get('/deleteFavorite/1/1');

        $response->assertStatus(403);
    }

    public function test_confirmAsAdmin(){
        $form = ['date' => '2023-01-15',
                'time' => '17:00:00',
                'number' => '5'];
        $user = User::find(3);
        $response = $this->actingAs($user)->post('/confirm/1/1', $form);

        $response->assertStatus(403);
    }

    public function test_reserveAsAdmin(){
        $form = ['date' => '2023-01-15',
                'time' => '17:00:00',
                'number' => '5'];

        $user = User::find(3);
        $response = $this->actingAs($user)
                            ->withSession(['form' => $form])
                            ->get('/reserve/1/1');

        $response->assertStatus(403);
    }

    public function test_doneReserveAsAdmin(){
        $user = User::find(3);
        $response = $this->actingAs($user)->get('/done');

        $response->assertStatus(403);
    }

    public function test_deleteReserveAsAdmin(){
        Reserve::create([
            'user_id' => '1',
            'shop_id' => '1',
            'date' => '2023-01-15',
            'time' => '17:00:00',
            'number' => '5'
        ]);

        $user = User::find(3);
        $response = $this->actingAs($user)->get('/deleteReserve/3');

        $response->assertStatus(403);
    }

    public function test_mypageAsAdmin(){
        $ave = [0,3.5,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $n = [0,2,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

        $user = User::find(3);
        $response = $this->actingAs($user)
                            ->withSession(['evaluation_ave' => $ave, 
                                            'evaluation_n' => $n])
                            ->get('/mypage');

        $response->assertStatus(403);
    }

    public function test_goToEvaluationAsAdmin(){
        $user = User::find(3);
        $response = $this->actingAs($user)->get('/evaluation/1');

        $response->assertStatus(403);
    }

    public function test_evaluationAsAdmin(){
        $form = ['evaluation' => 3,
                'evaluation_comment' => 'test'];

        $user = User::find(3);
        $response = $this->actingAs($user)->post('/evaluation/1', $form);

        $response->assertStatus(403);
    }
}
