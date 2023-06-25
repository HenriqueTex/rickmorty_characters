<?php

namespace Tests\Feature;

use App\Models\Character;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CharacterPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_not_list_characters_without_authentication()
    {

        Character::factory()->create();

        $response = $this->get('api/characters');

        $response->assertStatus(301);
    }

    public function test_can_not_show_a_character_without_authentication()
    {
        $character = Character::factory()->create();

        $response = $this->get('api/characters/' . $character->id);

        $response->assertStatus(301);
    }
    public function test_can_not_store_a_new_character_without_authentication()
    {
        $character = Character::factory()->raw();

        $response = $this->post('api/characters', $character);

        $response->assertStatus(301);
    }

    public function test_can_not_update_a_character_without_authentication()
    {
        $character = Character::factory()->create();

        $data = [
            'name' => 'Updated Name',
            'status' => 'Dead',
            'species' => 'Alien',
        ];

        $response = $this->put('api/characters/' . $character->id, $data);

        $response->assertStatus(301);
    }

    public function test_can_not_delete_a_character_without_authentication()
    {
        $character = Character::factory()->create();

        $response = $this->delete('api/characters/' . $character->id);

        $response->assertStatus(301);
    }
}
