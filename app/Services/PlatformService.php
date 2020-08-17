<?php

namespace App\Services;


use App\Http\Resources\PlatformResource;
use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformService{
    public function index(){
        return PlatformResource::collection(Platform::all());
    }

    public function paginate(){
        return PlatformResource::collection(Platform::orderBy('updated_at', 'desc')->paginate(4));
    }

    public function show($id){
        return PlatformResource::make(Platform::find($id));
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

        $platform = Platform::find($id);

        $platform->name = $request->name;

        $platform->save();
    }

    public function destroy($id){
        $platform = Platform::find($id);

        $platform->delete();
    }
}
