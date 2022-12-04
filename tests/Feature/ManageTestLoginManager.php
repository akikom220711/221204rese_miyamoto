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

class ManageTestLoginManager extends TestCase
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

    //managerでログインしている場合
    public function test_goToAdminAsManager(){
        $user = Manager::find(1);
        $response = $this->actingAs($user, 'managers')->get('/admin');

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_registManagerAsManager(){
        $form = [
            'manager_name' => 'test',
            'manager_email' => 'test@example.com',
            'manager_password' => 'testtest',
        ];

        $user = Manager::find(1);
        $response = $this->actingAs($user, 'managers')->post('/admin', $form);

        $response->assertStatus(302);
        $response->assertRedirect('userlogin');
    }

    public function test_goToManagerAsManager(){
        $user = Manager::find(1);
        $response = $this->actingAs($user, 'managers')->get('/manage');

        $response->assertStatus(200);
        $response->assertViewIs('manageHome');
    }

    public function test_goToCreateShopAsManager(){
        $user = Manager::find(1);
        $response = $this->actingAs($user, 'managers')->get('/createShop');

        $response->assertStatus(200);
        $response->assertViewIs('createShop');
    }

    public function test_createShopAsManager(){
        $form = [
            'shop_name' => 'test',
            'comment' => 'テキストが入ります',
            'url' => 'aaa',
            'region_id' => 13,
            'category_id' => 2,
        ];

        $user = Manager::find(1);
        $response = $this->actingAs($user, 'managers')->post('/createShop/1', $form);

        $response->assertStatus(200);
        $response->assertViewIs('doneCreateShop');

        $this->assertDatabaseHas('shops', [
                                    'shop_name' => 'test',
                                    'comment' => 'テキストが入ります',
                                    'url' => 'aaa',
                                    'region_id' => 13,
                                    'category_id' => 2,
                                    'manager_id' => 1
                                    ]);
    }

    public function test_goToUpdateShopAsManager(){
        $user = Manager::find(1);
        $response = $this->actingAs($user, 'managers')->get('/goToUpdateShop/1/1');

        $response->assertStatus(200);
        $response->assertViewIs('updateShop');
        $response->assertSee('仙人');
    }

    public function test_updateShopAsManager(){
        $form = [
            'shop_name' => 'mmm',
            'comment' => 'テキストが入ります',
            'url' => 'ccc',
            'region_id' => 10,
            'category_id' => 4,
        ];

        $user = Manager::find(1);
        $response = $this->actingAs($user, 'managers')->post('/updateShop/1', $form);

        $response->assertStatus(200);
        $response->assertViewIs('doneUpdateShop');

        $this->assertDatabaseHas('shops', [
                                    'shop_name' => 'mmm',
                                    'comment' => 'テキストが入ります',
                                    'url' => 'ccc',
                                    'region_id' => 10,
                                    'category_id' => 4,
                                    'manager_id' => 1
                                    ]);
    }

    public function test_showReserveAsManager(){
        $user = Manager::find(1);
        $response = $this->actingAs($user, 'managers')->get('/showReserve/4');

        $response->assertStatus(200);
        $response->assertViewIs('showReserve');
        $response->assertSee('ルーク');
        $response->assertSee('佐藤');
        $response->assertSee('2022-12-06');
        $response->assertSee('17:00');
        $response->assertSee('5人');
    }

    public function test_sendMailForUserAsManager(){
        $form = [
            'title' => '予約のご連絡',
            'mail_address' => 'aaa@example.com',
            'mail_text' => 'ご予約ありがとうございます。'
        ];
        $email = $form['mail_address'];

        Mail::fake();

        $user = Manager::find(1);
        $response = $this->actingAs($user, 'managers')->post('/sendMailForUser', $form);

        $response->assertStatus(302);
        Mail::assertSent(SendMail::class, 1);

        Mail::assertSent(SendMail::class, function ($mail) use ($email) {
            return $mail->hasTo($email);
        });
    }

}
