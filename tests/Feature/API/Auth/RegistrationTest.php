<?php

namespace Tests\Feature\API\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->setUpPassport();

        /* Make sure events don't actually fire */
        Event::fake();
    }

    /**
     * Tests a 'Perfect' Registration.
     *
     */
    public function testRegistration()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@test.test',
            'password' => 'testing',
            'password_confirmation' => 'testing',
        ];

        $response = $this->json('POST', route('api.register'), $data);

        /* Success Response */
        $response->assertStatus(Response::HTTP_OK);

        /* Check Json */
        $response->assertJsonStructure([
            'message',
            'token',
            'user',
        ]);

        /* Check DB */
        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $user = User::first();

        /* Make sure Event fired. */
        Event::assertDispatched(Registered::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });
    }

    /**
     * Tests that the Name is required and can't be too long.
     *
     */
    public function testNameValidation()
    {
        /* Base Data */
        $data = [
            'email' => 'test@test.test',
            'password' => 'testing',
            'password_confirmation' => 'testing',
        ];

        /* No Name Provided */
        $response = $this->json('POST', route('api.register'), $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'name',
        ]);

        /* Name Too Long */
        $data = array_merge($data, [
            'name' => str_random(256),
        ]);
        $response = $this->json('POST', route('api.register'), $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'name',
        ]);
    }

    /**
     * Tests email validation including uniqueness.
     *
     */
    public function testEmailValidation()
    {
        /* Base Data */
        $data = [
            'name' => 'Test User',
            'password' => 'testing',
            'password_confirmation' => 'testing',
        ];

        /* No Email Provided */
        $response = $this->json('POST', route('api.register'), $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'email',
        ]);

        /* Has to be an Email */
        $data = array_merge($data, [
            'email' => 'test',
        ]);
        $response = $this->json('POST', route('api.register'), $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'email',
        ]);

        /* Email too long */
        $data = array_merge($data, [
            'email' => str_random(256).'@test.test',
        ]);
        $response = $this->json('POST', route('api.register'), $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'email',
        ]);

        /* Email not Unique */
        $user = factory(\App\Models\User::class)->create();
        $data = array_merge($data, [
            'email' => $user->email,
        ]);
        $response = $this->json('POST', route('api.register'), $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'email',
        ]);
    }
}
