<?php

namespace Theme\Farmart\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductRazenInstituteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
        ];
    }
}
