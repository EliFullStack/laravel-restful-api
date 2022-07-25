<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testAnAuthenticatedUserCanLogout()
{
    $this->artisan('passport:install');

    $user = User::factory()->create();

    Passport::actingAs($user);

    $this->postJson('api/logout')
        ->assertStatus(200);
}

}
