<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'full_description' => $this->full_description,
            'icon' => $this->icon,
            'featured_image' => $this->featured_image,
            'benefits' => $this->benefits,
            'features' => $this->features,
            'faq' => $this->faq,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
