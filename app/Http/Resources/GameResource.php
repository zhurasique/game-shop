<?php

namespace App\Http\Resources;

use App\Models\CategoryInGame;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'category' => CategoryResource::collection(
                                    CategoryInGame::select()
                                    ->join('categories', 'category_in_games.category_id', '=', 'categories.id')
                                    ->where('category_in_games.game_id', $this->id)
                                    ->get()
            )
        ];
    }
}
