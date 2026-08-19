<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'price' => $this->price,
            'pricing_type' => $this->pricing_type,
            'images' => $this->images,
            'features' => $this->features,
            'benefits' => $this->benefits,
            'demo_url' => $this->demo_url,
            'documentation_url' => $this->documentation_url,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
