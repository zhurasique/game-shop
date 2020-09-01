<?php


namespace App\Services;

use App\Http\Resources\CategoryInGameResource;
use App\Repositories\CategoryInGameRepository;
use Illuminate\Http\Request;

class CategoryInGameService{

    private CategoryInGameRepository $categoryInGameRepo;
    public function __construct(CategoryInGameRepository $categoryInGameRepo){
        $this->categoryInGameRepo = $categoryInGameRepo;
    }

    public function getByCategoryId($id){
        return CategoryInGameResource::collection($this->categoryInGameRepo->getByCategoryId($id));
    }

    public function getByGameId($id){
        return CategoryInGameResource::collection($this->categoryInGameRepo->getByGameId($id));
    }

    public function store(Request $request){
        $this->categoryInGameRepo->store($request);
    }

    public function destroy($id){
        $categoryInGame = $this->categoryInGameRepo->getById($id);

        $categoryInGame->delete();;
    }

    public function destroyByIds($game_id, $category_id){
        $this->destroy($this->categoryInGameRepo->getByIds($game_id, $category_id)->id);
    }
}
