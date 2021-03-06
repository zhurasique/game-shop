<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller{

    private CategoryService $categoryService;
    public function __construct(CategoryService $categoryService){
        $this->categoryService = $categoryService;
    }

    public function index(){
        return $this->categoryService->index();
    }

    public function paginate(){
        return $this->categoryService->paginate();
    }

    public function show($id){
        return $this->categoryService->show($id);
    }

    public function getByPlatformId($id){
        return $this->categoryService->getByPlatformId($id);
    }

    public function store(Request $request){
        $this->categoryService->store($request);
    }

    public function update(Request $request, $id){
        $this->categoryService->update($request, $id);
    }

    public function destroy($id){
        $this->categoryService->destroy($id);
    }
}
