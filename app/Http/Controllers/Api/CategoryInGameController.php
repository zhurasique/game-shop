<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryInGameService;
use Illuminate\Http\Request;

class CategoryInGameController extends Controller{

    private CategoryInGameService $categoryInGameService;
    public function __construct(CategoryInGameService $categoryInGameService){
        $this->categoryInGameService = $categoryInGameService;
    }

    public function getByCategoryId($id){
        return $this->categoryInGameService->getByCategoryId($id);
    }

    public function getByGameId($id){
        return $this->categoryInGameService->getByGameId($id);
    }

    public function store(Request $request){
        $this->categoryInGameService->store($request);
    }

    public function destroy($id){
        $this->categoryInGameService->destroy($id);
    }
}
