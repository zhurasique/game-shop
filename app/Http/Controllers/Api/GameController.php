<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GameService;
use Illuminate\Http\Request;

class GameController extends Controller{

    private GameService $gameService;
    public function __construct(GameService $gameService){
        $this->gameService = $gameService;
    }

    public function index(){
        return $this->gameService->index();
    }

    public function paginate(){
        return $this->gameService->paginate();
    }

    public function show($id){
        return $this->gameService->show($id);
    }

    public function store(Request $request){
        $this->gameService->store($request);
    }

    public function update(Request $request, $id){
        $this->gameService->update($request, $id);
    }

    public function destroy($id){
        $this->gameService->destroy($id);
    }
}
