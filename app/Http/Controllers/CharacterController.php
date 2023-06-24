<?php

namespace App\Http\Controllers;

use App\Models\Character;

class CharacterController extends Controller
{
    public function index()
    {
        $charactersPerPage = 10;
        $characters = Character::paginate($charactersPerPage);

        if (!$characters) {
            abort(404, "No characters found");
        }

        $response = [
            'data' => $characters->items(),
            'pagination' => [
                'current_page' => $characters->currentPage(),
                'last_page' => $characters->lastPage(),
                'per_page' => $characters->perPage(),
                'total' => $characters->total(),
            ],
        ];

        return response()->json($response);
    }

    public function show(Character $character)
    {
        if (!$character) {
            abort(404, 'Character not found');
        }
        return response()->json($character);
    }
}
