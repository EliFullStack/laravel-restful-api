<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    public function testUserCanBeRegistratedAndIsInDatabase () {

        $this->artisan('passport:install');

        $this->withoutExceptionHandling();

        $response = $this->postJson('api/register', [
                'nickname' => 'testNickname',
                'email' => 'test@email.com',
                'password' => '12345678',
                'password_confirmation' => '12345678'
        ]);

        $response->assertCreated();

        $user = User::first();

        $this->assertCount(1, User::all());

        $this->assertEquals('testNickname', $user->nickname);

        $this->assertEquals('test@email.com', $user->email);

        $this->assertDatabaseHas('users', $user->toArray());
    }

    public function testRegistrationDisplaysValidationErrorsPassword()
    {
        $response = $this->post('api/register', []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors('password');
    }

    public function testEmailIsRequired () {

        $this->artisan('passport:install');

        $response = $this->post('api/register', [
            'nickname' => 'testNickname',
            'email' => '',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $response->assertSessionHasErrors(['email']);

    }

    public function testPasswordIsRequired () {

        $this->artisan('passport:install');

        $response = $this->post('api/register', [
            'nickname' => 'testNickname',
            'email' => 'test@email.com',
            'password' => '',
            'password_confirmation' => '12345678'
        ]);

        $response->assertSessionHasErrors(['password']);

    }

    public function testPasswordHasAtLeastEightcharacters () {

        $this->artisan('passport:install');

        $response = $this->post('api/register', [
            'nickname' => 'testNickname',
            'email' => 'test@email.com',
            'password' => '123',
            'password_confirmation' => '12345678'
        ]);

        $response->assertSessionHasErrors(['password']);

    }

    public function testPasswordConfirmationIsRequired () {

        $this->artisan('passport:install');

        $response = $this->post('api/register', [
            'nickname' => 'testNickname',
            'email' => 'test@email.com',
            'password' => '12345678',
            'password_confirmation' => ''
        ]);

        $response->assertSessionHasErrors(['password_confirmation']);

    }

    public function testUserCanBeRegisteredwithEmptyNickname () {

        $this->artisan('passport:install');

        $response = $this->postJson('api/register', [
            'nickname' => '',
            'email' => 'test@email.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $response->assertCreated();

    }  
    
    public function testNicknameCannotBeRepeated () {

        $this->artisan('passport:install');

        $response = $this->post('api/register',[
            'nickname' => 'testNickname',
            'email' => 'test@email.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
    ]);

    $response = $this->post('api/register',[
        'nickname' => 'testNickname',
        'email' => 'otrotest@email.com',
        'password' => '12345678',
        'password_confirmation' => '12345678'
    ]);

    $response->assertSessionHasErrors(['nickname']);    

    } 
    
    public function testEmailCannotBeRepeated () {

        $this->artisan('passport:install');

        $response = $this->post('api/register',[
            'nickname' => 'testNickname',
            'email' => 'test@email.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
    ]);

    $response = $this->post('api/register',[
        'nickname' => 'otroNickname',
        'email' => 'test@email.com',
        'password' => '12345678',
        'password_confirmation' => '12345678'
    ]);

    $response->assertSessionHasErrors(['email']);    

    }  

}
