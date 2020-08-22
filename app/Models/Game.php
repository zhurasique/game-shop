<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['name', 'price'];

    public function category(){
        return $this->hasMany(CategoryInGame::class);
    }
}
