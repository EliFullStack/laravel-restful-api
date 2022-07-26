<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLoginWithCorrectCredentials()
    {
        $this->artisan('passport:install');

        $user = User::factory()->create([
            'password' => bcrypt($password = '12345678'),
        ]);

        $response = $this->post('api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200);

        $this->assertAuthenticatedAs($user);
    }

    public function testLoginDisplaysValidationErrorsEmail()
    {
        $response = $this->post('api/login', []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors('email');
    }

    public function testLoginDisplaysValidationErrorsPassword()
    {
        $response = $this->post('api/login', []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors('password');
    }

    public function testEmailIsRequiredWhenLogIn () {

        $this->artisan('passport:install');

        $response = $this->post('api/login', [
            'email' => '',
            'password' => '12345678'
        ]);

        $response->assertSessionHasErrors(['email']);

        $response->assertStatus(302);

    }

    public function testPasswordIsRequiredWhenLogIn () {

        $this->artisan('passport:install');

        $response = $this->post('api/login', [
            'email' => 'test@email.com',
            'password' => ''
        ]);

        $response->assertSessionHasErrors(['password']);

        $response->assertStatus(302);

    }

}
