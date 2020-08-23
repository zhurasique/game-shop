<?php


namespace App\Services;

use App\Repositories\CategoryInGameRepository;

class CategoryInGameService{

    private CategoryInGameRepository $categoryInGameRepo;
    public function __construct(CategoryInGameRepository $categoryInGameRepo){
        $this->categoryInGameRepo = $categoryInGameRepo;
    }

    public function getByCategoryId($id){
        return $this->categoryInGameRepo->getByCategoryId($id);
    }

    public function getByGameId($id){
        return $this->getByGameId($id);
    }
}
