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
use App\Models\Manager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManagerAuthTest extends TestCase
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

    public function test_goToLoginManager()
    {
        $response = $this->get('/manager/userlogin');

        $response->assertStatus(200);
        $response->assertViewIs('loginManager');
    }

    public function test_LoginManager()
    {
        $form = ['email' => 'kkk@example.com', 'password' => 'kkkkkkkkk'];

        $response = $this->post('/manager/userlogin', $form);

        $response->assertStatus(302);
        $response->assertRedirect('/manage');
        $manager = Manager::find(1);
        $this->assertAuthenticatedAs($manager, $guard = 'managers');
    }

    public function test_LoginManagerFailed()
    {
        $form = ['email' => 'kkk@example.com', 'password' => '111111111'];

        $response = $this->post('/manager/userlogin', $form);

        $response->assertStatus(302);
        $response->assertRedirect('/manager/userlogin');
        $this->assertGuest();
    }

    public function test_logoutManager(){
        $manager = Manager::find(1);
        $response = $this->actingAs($manager, 'managers')->get('/manager/userlogout');

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
