<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Game;
use Laravel\Passport\Passport;

class GameTest extends TestCase
{
    use RefreshDatabase;

    public function testUnauthenticatedUserCannotListPlayersSuccessRate()
    {
        $response = $this->getJson('api/players');

        $response->assertStatus(401);
    }

    public function testAuthorizedUserCanListPlayersSuccessRate()
    {
        $this->withoutExceptionHandling();

        $this->artisan('passport:install');

        $admin = User::factory()->create(['role' => 1 ]);

        $admin = Passport::actingAs($admin);

        if ($admin['role'] == 1) {

            $response = $this->actingAs($admin, 'api')->getJson('api/players');

            $response->assertOk();

            $this->assertAuthenticated();
        }
    }

    public function testUnauthorizedUserCannotListPlayersSuccessRate()
    {
        $this->artisan('passport:install');

        $response = $this->getJson('api/players');

        $user = User::factory()->create(['role' => "0"]);

        if ($user->role !== 1) {
     
            $response->assertUnauthorized();
        }
       
    }

    public function testUnauthenticatedUserCannotThrowDice()
    {
        $response = $this->postJson('api/players/{id}/games');

        $response->assertStatus(401);
    }

    public function testUserCanThrowDice() {

        $this->withoutExceptionHandling();

        $this->artisan('passport:install');

        $user = User::factory()->create();

        $user = Passport::actingAs($user);

        $response = $this->actingAs($user, 'api')->postJson(route('api.players.throwDice', $user->id),
         [
            'dice1' => 5,
            'dice2' => 2,
            'winner_loser' => 1,
            'user_id'=>$user->id
        ]);

        $response->assertOk();

        $game = Game::first();

        $this->assertCount(1, Game::all());

        $this->assertDatabaseHas('games', $game->toArray());
    }
    
    public function testUnauthenticatedUserCannotListPlayerGames()
    {
        $response = $this->getJson('api/players/{id}/games');

        $response->assertStatus(401);
    }

    public function testUserCanListPlayerGames() {

        $this->artisan('passport:install');

        $user = User::factory()->create();

        $user = Passport::actingAs($user);

        $response = $this->actingAs($user, 'api')->getJson('api/players/{id}/games');

        $response->assertStatus(200);
    }


    public function testUnauthenticatedUserCannotDeletePlayerGames()
    {
        $response = $this->deleteJson('api/players/{id}/games');

        $response->assertStatus(401);
    }

    public function testUserCanDeletePlayerGames() {

        $this->artisan('passport:install');

        $user = User::factory()->create();

        $user = Passport::actingAs($user);

        $response = $this->actingAs($user, 'api')->deleteJson('api/players/{id}/games');

        $response->assertStatus(200);
    }

    public function testUnauthenticatedUserCannotListRanking()
    {
        $response = $this->getJson('api/players/ranking');

        $response->assertStatus(401);
    }

    public function testAuthorizedUserCanListRanking() {

        $this->artisan('passport:install');

        $admin = User::factory()->create(['role' => 1 ]);

        $admin = Passport::actingAs($admin);

        if ($admin['role'] == 1) {

            $response = $this->actingAs($admin, 'api')->getJson('api/players/ranking');

            $response->assertOk();

            $this->assertAuthenticated();
        }
    }

    public function testUnauthorizedUserCannotListRanking() {

        $this->artisan('passport:install');

        $response = $this->getJson('api/players/ranking');

        $user = User::factory()->create(['role' => "0"]);

        if ($user->role !== 1) {
     
            $response->assertUnauthorized();
        }
    }

    public function testUnauthenticatedUserCannotListWinner()
    {
        $response = $this->getJson('api/players/ranking/winner');

        $response->assertStatus(401);
    }

    public function testAuthorizedUserCanListWinner() {

        $this->withoutExceptionHandling();

        $this->artisan('passport:install');

        $admin = User::factory()->create(['role' => 1 ]);

        $admin = Passport::actingAs($admin);

        if ($admin['role'] == 1) {

            $response = $this->actingAs($admin, 'api')->getJson('api/players/ranking/winner');

            $response->assertOk();

            $this->assertAuthenticated();
        }
    }

    public function testUnauthorizedUserCannotListWinner() {

        $this->artisan('passport:install');

        $response = $this->getJson('api/players/ranking/winner');

        $user = User::factory()->create(['role' => "0"]);

        if ($user->role !== 1) {
     
            $response->assertUnauthorized();
        }
    }

    public function testUnauthenticatedUserCannotListLoser()
    {
        $response = $this->getJson('api/players/ranking/loser');

        $response->assertStatus(401);
    }

    public function testAuthorizedUserCanListLoser() {

        $this->withoutExceptionHandling();

        $this->artisan('passport:install');

        $admin = User::factory()->create(['role' => 1 ]);

        $admin = Passport::actingAs($admin);

        if ($admin['role'] == 1) {

            $response = $this->actingAs($admin, 'api')->getJson('api/players/ranking/loser');

            $response->assertOk();

            $this->assertAuthenticated();
        }
    }

    public function testUnauthorizedUserCannotListLoser() {

        $this->artisan('passport:install');

        $response = $this->getJson('api/players/ranking/loser');

        $user = User::factory()->create(['role' => "0"]);

        if ($user->role !== 1) {
     
            $response->assertUnauthorized();
        }
    }

    
}
        
