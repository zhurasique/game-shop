<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PlatformService;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    private PlatformService $platformService;
    public function __construct(PlatformService $platformService)
    {
        $this->platformService = $platformService;
    }

    public function index()
    {
        return $this->platformService->index();
    }

    public function show($id){
        return $this->platformService->show($id);
    }
}
