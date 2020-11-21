<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeShort extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'preview' => $this->preview,
            'cookingTime' => $this->cooking_time,
            'portions' => $this->portions,
            'language' => new Language($this->language),
            'user' => new User($this->user),
            'publishedAt' => $this->created_at->format('d.m.Y H:i:s'),
        ];
    }
}
