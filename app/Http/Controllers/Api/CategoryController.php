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

}
