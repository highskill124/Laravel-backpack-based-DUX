<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryGalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'image_id' => $this->id,
            'image_path' => $this->category_image != '' ? "https://dux.city/duxapi/category/" . $this->category_image : $this->category_image,
        ];
    }
}
