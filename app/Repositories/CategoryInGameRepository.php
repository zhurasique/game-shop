<?php


namespace App\Repositories;


use App\Models\CategoryInGame;
use App\Repositories\Interfaces\CategoryInGameRepositoryInterface;

class CategoryInGameRepository implements CategoryInGameRepositoryInterface {

    public function getByCategoryId($id){
        return CategoryInGame::where('category_id', $id)->get();
    }

    public function getByGameId($id){
        return CategoryInGame::where('game_id', $id)->get();
    }
}
