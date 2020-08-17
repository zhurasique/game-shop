<?php

namespace App\Http\Resources;

use App\Models\Platform;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'platform_id' => PlatformResource::make(Platform::find($this->platform_id)),
        ];
    }
}
