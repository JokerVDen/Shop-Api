<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserStoreTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     * @test
     */
    public function store_new_user()
    {
        $response = $this->json('POST', route('users.store', [], false), $this->inputUserData());

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name'  => 'TEST',
            'email' => 'test@test1.com',
        ]);
    }

    /**
     * @return void
     * @test
     */
    public function assert_400_when_store_new_user_with_isnt_unique_email()
    {
        $this->json('POST', route('users.store', [], false), $this->inputUserData());

        $response = $this->json('POST', route('users.store', [], false), $this->inputUserData());

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function assert_200_when_two_different_email()
    {
        $userData = $this->inputUserData();

        $this->json('POST', route('users.store', [], false), $userData);

        $otherData = array_merge($userData, ['email' => 'some.other@email.com']);

        $response = $this->json('POST', route('users.store', [], false), $otherData);

        $response->assertStatus(200);
    }

    protected function inputUserData()
    {
        return [
            'name'                  => 'TEST',
            'email'                 => 'test@test1.com',
            'password'              => '123456',
            'password_confirmation' => '123456',
        ];
    }
}
