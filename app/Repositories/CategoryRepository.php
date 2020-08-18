<?php


namespace App\Repositories;


use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface {

    public function all(){
        return Category::all();
    }

    public function orderByUpdate(){
        return Category::orderBy('updated_at', 'desc');
    }

    public function getById($id){
        return Category::where('id', $id)->first();
    }

    public function getByPlatformId($id){
        return Category::where('platform_id', $id)->get();
    }
}
