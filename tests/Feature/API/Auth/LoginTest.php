<?php

namespace Tests\Feature\API\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->setUpPassport();

        /* Create a new User */
        $this->user = factory(\App\Models\User::class)->create([
            'email' => 'test@test.test',
            'password' => 'secret',
        ]);
    }

    /**
     * Tests a 'Perfect' Login attempt.
     *
     */
    public function testLogin()
    {
        $data = [
            'email' => $this->user->email,
            'password' => 'secret',
        ];

        $response = $this->json('POST', route('api.login'), $data);

        /* Success Response */
        $response->assertStatus(Response::HTTP_OK);

        /* Check Json */
        $response->assertJsonStructure([
            'message',
            'token',
            'user',
        ]);
    }

    /**
     * Tests the validation rules for the email field.
     *
     */
    public function testEmailValidation()
    {
        /* Base Data */
        $data = [
            'password' => 'secret',
        ];

        /* No Email Provided */
        $response = $this->json('POST', route('api.login'), $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'email',
        ]);

        /* Email is not an Email */
        $data = array_merge($data, [
            'email' => 'blah',
        ]);
        $response = $this->json('POST', route('api.login'), $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'email',
        ]);

        /* Account Doesn't Exist */
        $data = array_merge($data, [
            'email' => 'blah@test.test',
        ]);
        $response = $this->json('POST', route('api.login'), $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([
            'message' => __('auth.account_not_found'),
        ]);
    }

    /**
     * Tests when a password is not present and when it is incorrect.
     *
     */
    public function testPasswordValidation()
    {
        /* Base Data */
        $data = [
            'email' => $this->user->email,
        ];

        /* No Password Provided */
        $response = $this->json('POST', route('api.login'), $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'password',
        ]);

        /* Password Doesn't Match */
        $data = array_merge($data, [
            'password' => 'blah',
        ]);
        $response = $this->json('POST', route('api.login'), $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([
            'message' => __('auth.invalid_password'),
        ]);
    }
}
