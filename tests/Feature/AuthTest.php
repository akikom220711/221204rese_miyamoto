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
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
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

    public function test_goToRegister(){
        $response = $this->get('/regist');

        $response->assertStatus(200);
        $response->assertViewIs('regist');
    }

    public function test_register(){
        $form = [
            'name' => '吉田',
            'email' => 'test@example.com',
            'password' => 'testtest',
        ];

        $response = $this->post('/regist', $form);

        $this->assertDatabaseHas('users', ['name' => '吉田', 'email' => 'test@example.com']);

        $user = User::find(4);
        $this->assertTrue(Hash::check('testtest', $user->password));
        $this->assertAuthenticatedAs($user);
    }

    public function test_thanks(){
        $response = $this->get('/thanks');

        $response->assertStatus(200);
        $response->assertViewIs('thanks');
    }

    public function test_goToLogin(){
        $response = $this->get('/userlogin');

        $response->assertStatus(200);
        $response->assertViewIs('login');
    }

    public function test_login(){
        $form = ['email' => 'aaa@example.com', 'password' => 'aaaaaaaaa'];

        $response = $this->post('/userlogin', $form);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $user = User::find(1);
        $this->assertAuthenticatedAs($user);
    }

    public function test_loginFailed(){
        $form = ['email' => 'aaa@example.com', 'password' => 'lllllllll'];

        $response = $this->post('/userlogin', $form);

        $this->assertGuest();
        $response->assertStatus(302);
        $response->assertRedirect('/userlogin');
    }

    public function test_logout(){
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/userlogout');

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
