<?php

namespace Tests\Feature;

use App\Models\Character;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CharacterControllerTest extends TestCase
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

    public function test_can_list_characters()
    {
        $charactersQuantity = 10;

        Character::factory()->count($charactersQuantity)->create();

        $response = $this->get('api/characters', ['Authorization' => $this->bearerToken]);

        $this->assertEquals(count(json_decode($response->getContent())->data), $charactersQuantity);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'pagination' => [
                    'current_page',
                    'last_page',
                    'per_page',
                    'total',
                ],
            ]);
    }

    public function test_can_show_a_character()
    {
        $character = Character::factory()->create();

        $response = $this->get('api/characters/' . $character->id, ['Authorization' => $this->bearerToken]);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $character->id,
                'name' => $character->name,
                // Adicione aqui os outros campos que deseja testar
            ]);
    }

    public function test_can_show_a_character_with_wrong_id()
    {
        $character = Character::factory()->create();

        $nonexistingId = $character->id + 1;

        $response = $this->get('api/characters/' . $nonexistingId, ['Authorization' => $this->bearerToken]);

        $response->assertStatus(404);
    }

    public function test_can_store_a_new_character()
    {
        $character = Character::factory()->raw();

        $response = $this->post('api/characters', $character, ['Authorization' => $this->bearerToken]);

        $jsonCompare = [
            'name' => $character['name'],
            'status' => $character['status'],
            'species' => $character['species'],
            'type' => $character['type'],
            'gender' => $character['gender'],
            'image' => $character['image'],
            'url' => $character['url'],
        ];

        $response->assertStatus(201)
            ->assertJson($jsonCompare);

        $this->assertDatabaseHas(
            'characters',
            $jsonCompare
        );
    }

    public function test_can_update_a_character()
    {
        $character = Character::factory()->create();

        $data = [
            'name' => 'Updated Name',
            'status' => 'Dead',
            'species' => 'Alien',
        ];

        $response = $this->put('api/characters/' . $character->id, $data, ['Authorization' => $this->bearerToken]);

        $response->assertStatus(200)
            ->assertJson([
                'name' => $data['name'],
                'status' => $data['status'],
                'species' => $data['species'],
                'type' => $character['type'],
                'gender' => $character['gender'],
                'image' => $character['image'],
                'url' => $character['url'],
            ]);

        $this->assertDatabaseHas('characters', [
            'id' => $character->id,
            'name' => $data['name'],
            'status' => $data['status'],
            'species' => $data['species'],
            'type' => $character['type'],
            'gender' => $character['gender'],
            'image' => $character['image'],
            'url' => $character['url'],
        ]);
    }

    public function test_can_delete_a_character()
    {
        $character = Character::factory()->create();

        $response = $this->delete('api/characters/' . $character->id, ['Authorization' => $this->bearerToken]);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('characters', [
            'id' => $character->id,
        ]);
    }

    public function test_can_not_delete_a_character_with_wrong_id()
    {
        $character = Character::factory()->create();

        $nonexistingId = $character->id + 1;

        $response = $this->delete('api/characters/' . $nonexistingId, ['Authorization' => $this->bearerToken]);

        $response->assertStatus(404);
    }
}
