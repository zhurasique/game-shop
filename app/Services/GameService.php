<?php


namespace App\Services;

use App\Http\Resources\GameResource;
use App\Repositories\GameRepository;
use Illuminate\Http\Request;

class GameService{

    private GameRepository $gameRepo;
    public function __construct(GameRepository $gameRepo){
        $this->gameRepo = $gameRepo;
    }

    public function index(){
        return GameResource::collection($this->gameRepo->all());
    }

    public function paginate(){
        return GameResource::collection($this->gameRepo->orderByUpdate()->paginate(4));
    }

    public function show($id){
        return GameResource::make($this->gameRepo->getById($id));
    }

    public function store(Request $request){
        $this->gameRepo->store($request);
    }

    public function update(Request $request, $id){
        $this->gameRepo->update($request, $id);
    }

    public function destroy($id){
        $game = $this->gameRepo->getById($id);

        $game->delete();
    }
}
