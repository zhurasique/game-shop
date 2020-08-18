<?php


namespace App\Repositories\Interfaces;


use App\Models\Category;
use App\Models\Platform;
use Illuminate\Http\Request;

interface PlatformRepositoryInterface{
    public function all();

    public function getById($id);

    public function orderByUpdate();

    public function store(Request $request);

    public function update(Request $request, $id);

    public function destroy(Platform $platform, Category $category);
}
