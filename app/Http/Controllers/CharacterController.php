<?php

namespace App\Http\Controllers;

use App\Models\Character;
use OpenApi\Annotations\Parameter;

class CharacterController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/characters",
     *     tags={"Characters"},
     *     summary="List Characters",
     *     description="Get a paginated list of characters.",
     *     security={{"bearerAuth":{}}},
     * @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Character")
     *             ),
     *             @OA\Property(
     *                 property="pagination",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer"),
     *                 @OA\Property(property="last_page", type="integer"),
     *                 @OA\Property(property="per_page", type="integer"),
     *                 @OA\Property(property="total", type="integer")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No characters found"
     *     )
     * )
     *
     * @OA\Schema(
     *     schema="Character",
     *     required={"id", "name", "status", "species", "type", "gender", "origin", "location", "image", "episode", "url", "created"},
     *     @OA\Property(property="id", type="integer"),
     *     @OA\Property(property="name", type="string"),
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="species", type="string"),
     *     @OA\Property(property="type", type="string"),
     *     @OA\Property(property="gender", type="string"),
     *     @OA\Property(property="origin", type="object", ref="#/components/schemas/Location"),
     *     @OA\Property(property="location", type="object", ref="#/components/schemas/Location"),
     *     @OA\Property(property="image", type="string", format="url"),
     *     @OA\Property(property="episode", type="array", @OA\Items(type="string", format="url")),
     *     @OA\Property(property="url", type="string", format="url"),
     *     @OA\Property(property="created", type="string", format="date-time")
     * )
     *
     * @OA\Schema(
     *     schema="Location",
     *     @OA\Property(property="name", type="string"),
     *     @OA\Property(property="link", type="string", format="url")
     * )
     */
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
    /**
     * @OA\Get(
     *     path="/api/characters/{character}",
     *     tags={"Characters"},
     *     summary="Show Character",
     *     description="Get details of a specific character.",
     *     @OA\Parameter(
     *         name="character",
     *         in="path",
     *         description="ID of the character",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Character")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Character not found"
     *     )
     * )
     */

    public function show(Character $character)
    {
        if (!$character) {
            abort(404, 'Character not found');
        }
        return response()->json($character);
    }
}
