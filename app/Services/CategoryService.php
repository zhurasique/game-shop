<?php


namespace App\Services;


use App\Http\Resources\CategoryResource;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryService{

    private CategoryRepository $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo){
        $this->categoryRepo = $categoryRepo;
    }

    public function index(){
        return CategoryResource::collection($this->categoryRepo->all());
    }

    public function paginate(){
        return CategoryResource::collection($this->categoryRepo->orderByUpdate()->paginate(4));
    }

    public function show($id){
        return CategoryResource::make($this->categoryRepo->getById($id));
    }

    public function getByPlatformId($id){
        return CategoryResource::collection($this->categoryRepo->getByPlatformId($id));
    }

    public function store(Request $request){
        $this->categoryRepo->store($request);
    }

    public function update(Request $request, $id){
        $this->categoryRepo->update($request, $id);
    }

    public function destroy($id){
        $platform = $this->categoryRepo->getById($id);

        $platform->delete();
    }
}
