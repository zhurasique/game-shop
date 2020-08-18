<?php


namespace App\Repositories\Interfaces;


interface CategoryRepositoryInterface{
    public function all();

    public function orderByUpdate();

    public function getById($id);

    public function getByPlatformId($id);
}
