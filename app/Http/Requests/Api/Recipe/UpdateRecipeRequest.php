<?php

namespace App\Http\Requests\Api\Recipe;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
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
            'title' => 'sometimes|max:64',
            'description' => 'sometimes|max:500',
            'preview' => 'max:255',
            'cooking_time' => 'sometimes|date_format:H:i:s',
            'portions' => 'integer',
            'language_id' => 'sometimes|integer|exists:App\Models\Language,id',
        ];
    }
}
