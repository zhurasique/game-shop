<?php


namespace App\Repositories\Interfaces;


use Illuminate\Http\Request;

interface CategoryInGameRepositoryInterface{
    public function getById($id);

    public function getByCategoryId($id);

    public function getByGameId($id);

    public function store(Request $request);

    public function getByIds($game_id, $category_id);
}
