<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Game;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryInGameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category' => CategoryResource::make(Category::find($this->category_id)),
            'game' => GameResource::make(Game::find($this->game_id))
        ];
    }
}
