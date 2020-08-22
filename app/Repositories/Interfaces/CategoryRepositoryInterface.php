<?php


namespace App\Repositories\Interfaces;


use Illuminate\Http\Request;

interface CategoryRepositoryInterface{
    public function all();

    public function orderByUpdate();

    public function getById($id);

    public function getByPlatformId($id);

    public function store(Request $request);

    public function update(Request $request, $id);
}
