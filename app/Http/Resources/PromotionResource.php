<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
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
            'id' => $this->id,
            'location_ids' => $this->location_ids,
            'promotion_title' => $this->promotion_title,
            'promotion_description' => $this->promotion_description,
            'vip_promotion' => $this->vip_promotion,
            'vip_promotion_description' => $this->vip_promotion_description,
            'promotion_fineprint' => $this->promotion_fineprint,
            'is_ongoing_promotion' => $this->is_ongoing_promotion,
            'is_active' => $this->is_active,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'locations' => LocationResource::collection($this->locations)
        ];
    }
}
