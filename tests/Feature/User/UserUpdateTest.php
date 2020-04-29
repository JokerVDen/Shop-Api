<?php

namespace Tests\Feature\User;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->json('POST', route('users.store', [], false), $this->inputUserData());
    }

    protected function inputUserData()
    {
        return [
            'name'                  => 'TEST',
            'email'                 => 'test@test1.com',
            'password'              => '123456',
            'password_confirmation' => '123456',
            'admin'                 => UserType::REGULAR,
            'verified'              => true,
        ];
    }

    /**
     * @test
     */
    public function assert_422_when_user_not_exists()
    {
        $userId = 2;

        $response = $this->json('PATCH', route('users.update', $userId), $this->inputUserData());

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function assert_422_when_user_not_verified_and_adding_admin()
    {
        $userId = 1;

        $input = array_merge($this->inputUserData(), [
            'name'  => 'admin',
            'admin' => UserType::ADMIN,
        ]);
        $response = $this->json('PATCH', route('users.update', $userId), $input);

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function assert_200_when_user_data_valid()
    {
        $inputValid = array_merge($this->inputUserData(), [
            'name'  => 'admin',
            'email' => 'some@dd.com',
            'admin' => UserType::ADMIN,
            'verified' => true,
        ]);

        $user = User::create($inputValid);

        $inputValid = array_merge($inputValid, [
            'name'  => 'Other Admin',
            'admin' => UserType::REGULAR,
        ]);

        $response = $this->json('PATCH', route('users.update', $user->id), $inputValid);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name'  => 'Other Admin',
            'admin' => UserType::REGULAR,
        ]);
    }

    /**
     * @test
     */
    public function assert_422_when_admin_input_is_invalid()
    {
        $userData = array_merge($this->inputUserData(), ['admin' => 'error']);

        $response = $this->json('PATCH', route('users.update', 1), $userData);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function assert_422_when_email_is_invalid()
    {
        $userData = array_merge($this->inputUserData(), [
            'email' => 'adfsadf',
        ]);

        $response = $this->json('PATCH', route('users.update', 1), $userData);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function assert_422_when_password_isnt_confirmed()
    {
        $userData = array_merge($this->inputUserData(), [
            'password' => '2223333',
        ]);

        $response = $this->json('PATCH', route('users.update', 1), $userData);
        $response->assertStatus(422);
    }
}
