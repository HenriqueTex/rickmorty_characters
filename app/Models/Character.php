<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'characters';


    /**
     * The attributes that are mass assignable.
     *
     * name: The name of the character.
     * status: The status of the character ('Alive', 'Dead', or 'unknown').
     * species: The species of the character.
     * type: The type or subspecies of the character.
     * gender: The gender of the character ('Female', 'Male', 'Genderless', or 'unknown').
     * origin: Name and link to the character's origin location.
     * location: Name and link to the character's last known location endpoint.
     * image: Link to the character's image. All images are 300x300px and most are medium shots or portraits since they are intended to be used as avatars.
     * episode: List of episodes in which this character appeared.
     * url: Link to the character's own URL endpoint.
     * created: Time at which the character was created in the database.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status', 'species', 'type', 'gender', 'origin', 'location', 'image', 'episode', 'url', 'created'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'origin' => 'object',
        'location' => 'object',
        'episode' => 'array',
    ];
}
