<?php

namespace App\Http\Requests\Api\Recipe;

use Illuminate\Foundation\Http\FormRequest;

class CreateRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:64',
            'description' => 'required|max:500',
            'preview' => 'max:255',
            'cooking_time' => 'required|date_format:H:i:s',
            'portions' => 'integer',
            'language_id' => 'required|integer|exists:App\Models\Language,id',
            'recipe_body_id' => 'required|integer|unique:App\Models\Recipe,recipe_body_id',
            'user_id' => 'required|integer|exists:App\Models\User,id',
        ];
    }
}
