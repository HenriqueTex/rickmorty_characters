<?php

namespace Database\Factories;

use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'status' => $this->faker->randomElement(['Alive', 'Dead', 'unknown']),
            'species' => $this->faker->word,
            'type' => $this->faker->word,
            'gender' => $this->faker->randomElement(['Female', 'Male', 'Genderless', 'unknown']),
            'origin' => [
                'name' => $this->faker->word,
                'link' => $this->faker->url,
            ],
            'location' => [
                'name' => $this->faker->word,
                'link' => $this->faker->url,
            ],
            'image' => $this->faker->imageUrl(300, 300),
            'episode' => [$this->faker->url],
            'url' => $this->faker->url,
        ];
    }
}
