<?php


namespace App\Repositories;


use App\Models\Category;
use App\Models\Platform;
use App\Repositories\Interfaces\PlatformRepositoryInterface;
use Illuminate\Http\Request;

class PlatformRepository implements PlatformRepositoryInterface {

    public function all(){
        return Platform::all();
    }

    public function getById($id){
        return Platform::where('id', $id)->first();
    }

    public function orderByUpdate(){
        return Platform::orderBy('updated_at', 'desc');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'unique:platforms|required|string|max:15|min:2'
        ]);

        $platform = new Platform();
        $platform->name = $request->name;

        $platform->save();
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'unique:platforms|required|string|max:15|min:2'
        ]);

        $platform = $this->getById($id);

        $platform->name = $request->name;

        $platform->save();
    }
}
