<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Character;
use Carbon\Carbon;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::get('https://rickandmortyapi.com/api/character');
        $data = $response->json();

        foreach ($data['results'] as $characterData) {
            $created = Carbon::parse($characterData['created'])->format('Y-m-d H:i:s');
            Character::create([
                'name' => $characterData['name'],
                'status' => $characterData['status'],
                'species' => $characterData['species'],
                'type' => $characterData['type'],
                'gender' => $characterData['gender'],
                'origin' => $characterData['origin'],
                'location' => $characterData['location'],
                'image' => $characterData['image'],
                'episode' => $characterData['episode'],
                'url' => $characterData['url'],
                'created' => $created,
            ]);
        }
    }
}
