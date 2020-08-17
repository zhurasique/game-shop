<?php


namespace App\Services;


use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryService{
    public function index(){
        return CategoryResource::collection(Category::all());
    }

    public function paginate(){
        return CategoryResource::collection(Category::orderBy('updated_at', 'desc')->paginate(4));
    }

    public function show($id){
        return CategoryResource::make(Category::find($id));
    }
}
