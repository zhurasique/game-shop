<?php

namespace App\Services;


use App\Http\Resources\PlatformResource;
use App\Repositories\CategoryRepository;
use App\Repositories\PlatformRepository;
use Illuminate\Http\Request;

class PlatformService{

    private PlatformRepository $platformRepo;
    private CategoryRepository $categoryRepo;

    public function __construct(PlatformRepository $platformRepo, CategoryRepository $categoryRepo){
        $this->platformRepo = $platformRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function index(){
        return PlatformResource::collection($this->platformRepo->all());
    }

    public function paginate(){
        return PlatformResource::collection($this->platformRepo->orderByUpdate()->paginate(4));
    }

    public function show($id){
        return PlatformResource::make($this->platformRepo->getById($id));
    }

    public function store(Request $request){
        $this->platformRepo->store($request);
    }

    public function update(Request $request, $id){
        $this->platformRepo->update($request, $id);
    }

    public function destroy($id){
        $platform = $this->platformRepo->getById($id);

        $categories = $this->categoryRepo->getByPlatformId($id);

        foreach ($categories as $category)
            $category->delete();
        $platform->delete();
    }
}
