<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'preview',
        'cooking_time',
        'portions',
        'language_id',
        'recipe_body_id',
        'user_id',
    ];
}
