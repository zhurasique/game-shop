<?php


namespace App\Services;

use App\Http\Resources\CategoryInGameResource;
use App\Repositories\CategoryInGameRepository;

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
}
