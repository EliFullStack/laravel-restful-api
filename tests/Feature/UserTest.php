<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthorizedUserCanListAllPlayers()
    {
        $this->artisan('passport:install');

        $admin = User::factory()->create(['role' => "1"]);

        $admin = Passport::actingAs($admin);

        if ($admin['role'] == 1) {

            $response = $this->actingAs($admin, 'api')->getJson('api/users');
            
            $response->assertOk();
     
            $this->assertAuthenticated();
        }
        
    }

    public function testUnauthorizedUserCannotListAllPlayers()
    {
        $this->artisan('passport:install');

        $response = $this->getJson('api/users');

        $user = User::factory()->create(['role' => "0"]);

        if ($user->role !== 1) {
            
            $response->assertStatus(401);
     
            $response->assertUnauthorized();
        }
       
    }

    public function testNicknameCanBeUpdated () {

        $this->artisan('passport:install');

        $user = User::factory()->create();

        $user = Passport::actingAs($user);

        $response = $this->actingAs($user, 'api')->put(route('api.players.updateName', $user->id),
        
        ['nickname' => 'elita',
         'email' => 'elita@email.com'  
        ]);
        $this->assertAuthenticated();

        $response->assertOk();

        $this->assertDatabaseHas('users', ['nickname' => 'elita']);
    }

    
}



    

