<?php


namespace App\Repositories;


use App\Models\Game;
use App\Repositories\Interfaces\GameRepositoryInterface;
use Illuminate\Http\Request;

class GameRepository implements GameRepositoryInterface {

    public function all(){
        return Game::all();
    }

    public function orderByUpdate(){
        return Game::orderBy('updated_at', 'desc');
    }

    public function getById($id){
        return Game::where('id', $id)->first();
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:15|min:2',
            'price' => 'required|numeric'
        ]);

        $game = new Game();
        $game->name = $request->name;
        $game->price = $request->price;

        $game->save();
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:15|min:2',
            'price' => 'required|numeric'
        ]);

        $game = $this->getById($id);
        $game->name = $request->name;
        $game->price = $request->price;

        $game->save();
    }
}
