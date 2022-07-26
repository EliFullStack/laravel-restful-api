<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class LogoutTest extends TestCase
{

    public function testAnAuthenticatedUserCanLogout()
    {

    $this->artisan('passport:install');

    $user = User::factory()->create();

    
    Passport::actingAs($user);

    $response = $this->postJson('api/logout');

    $response->assertStatus(200);

    }
}
