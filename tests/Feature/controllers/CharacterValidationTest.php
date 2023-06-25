<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Character;
use App\Models\User;

class CharacterValidationTest extends TestCase
{
    use RefreshDatabase;

    public $bearerToken = '';

    /**
     * Get a jwt token before each test to auth the user.
     */
    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['password' => bcrypt('password')]);

        $response = $this->post(route('login'), ['email' => $user->email, 'password' => 'password']);

        $this->bearerToken = $response->getContent();
    }

    public function test_can_not_create_without_required_data()
    {
        $response = $this->post('/api/characters', [], ['Authorization' => $this->bearerToken]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'status',
                'species',
                'gender',
                'image',
                'episode',
            ]);
    }

    public function test_can_not_create_with_invalid_data()
    {
        $response = $this->post(
            '/api/characters',
            ['status' => 'invalid', 'gender' => 'invalid', 'image' => 'invalid', 'episode' => 'invalid'],
            ['Authorization' => $this->bearerToken]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status', 'gender', 'image', 'episode']);
    }

    public function test_can_not_update_character_with_invalid_data()
    {
        $character = Character::factory()->create();

        $response = $this->put(
            '/api/characters/' . $character->id,
            ['status' => 'invalid', 'gender' => 'invalid', 'image' => 'invalid', 'episode' => 'invalid'],
            ['Authorization' => $this->bearerToken]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status', 'gender', 'image', 'episode']);
    }
}
