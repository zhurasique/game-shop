<?php

namespace App\Services;


use App\Http\Resources\PlatformResource;
use App\Models\Platform;

class PlatformService
{
    public function index(){
        return PlatformResource::collection(Platform::all());
    }

    public function show($id){
        return PlatformResource::make(Platform::find($id));
    }
}
