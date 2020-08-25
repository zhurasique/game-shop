<?php


namespace App\Repositories;


use App\Models\CategoryInGame;
use App\Repositories\Interfaces\CategoryInGameRepositoryInterface;
use Illuminate\Http\Request;

class CategoryInGameRepository implements CategoryInGameRepositoryInterface {

    public function getById($id){
        return CategoryInGame::where('id', $id)->first();
    }

    public function getByCategoryId($id){
        return CategoryInGame::where('category_id', $id)->get();
    }

    public function getByGameId($id){
        return CategoryInGame::where('game_id', $id)->get();
    }

    public function store(Request $request){
        $request->validate([
            'category_id' => 'required',
            'game_id' => 'required'
        ]);

        $categoryInGame = new CategoryInGame();
        $categoryInGame->category_id = $request->category_id;
        $categoryInGame->game_id = $request->game_id;

        $categoryInGame->save();
    }
}
