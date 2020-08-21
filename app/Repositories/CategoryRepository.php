<?php


namespace App\Repositories;


use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;

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

    public function store(Request $request){
        $request->validate([
            'name' => 'unique:platforms|required|string|max:15|min:2',
            'platform_id' => 'required'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->platform_id = $request->platform_id;

        $category->save();
    }
}
