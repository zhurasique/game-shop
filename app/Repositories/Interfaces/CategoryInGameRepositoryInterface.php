<?php


namespace App\Repositories\Interfaces;


interface CategoryInGameRepositoryInterface{
    public function getByCategoryId($id);

    public function getByGameId($id);
}
