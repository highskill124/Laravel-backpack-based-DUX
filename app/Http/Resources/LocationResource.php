<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $sunday = [
            "is_open" => 0,
            "open" => 0,
            "close" => 0
        ];

        if ($this->is_open_sunday === 1) {
            $sunday = [
                "is_open" => 1,
                "open" => $this->start_time_sunday,
                "close" => $this->close_time_sunday
            ];
        }

        $monday = [
            "is_open" => 0,
            "open" => 0,
            "close" => 0
        ];
        if ($this->is_open_monday === 1) {
            $monday = [
                "is_open" => 1,
                "open" => $this->start_time_monday,
                "close" => $this->close_time_monday
            ];
        }

        $tuesday = [
            "is_open" => 0,
            "open" => 0,
            "close" => 0
        ];
        if ($this->is_open_tuesday === 1) {
            $tuesday = [
                "is_open" => 1,
                "open" => $this->start_time_tuesday,
                "close" => $this->close_time_tuesday
            ];
        }

        $wednesday = [
            "is_open" => 0,
            "open" => 0,
            "close" => 0
        ];
        if ($this->is_open_wednesday === 1) {
            $wednesday = [
                "is_open" => 1,
                "open" => $this->start_time_wednesday,
                "close" => $this->close_time_wednesday
            ];
        }

        $thrusday = [
            "is_open" => 0,
            "open" => 0,
            "close" => 0
        ];

        if ($this->is_open_thrusday === 1) {
            $thrusday = [
                "is_open" => 1,
                "open" => $this->start_time_thrusday,
                "close" => $this->close_time_thrusday
            ];
        }

        $friday = [
            "is_open" => 0,
            "open" => 0,
            "close" => 0
        ];

        if ($this->is_open_friday === 1) {
            $friday = [
                "is_open" => 1,
                "open" => $this->start_time_friday,
                "close" => $this->close_time_friday
            ];
        }

        $saturday = [
            "is_open" => 0,
            "open" => 0,
            "close" => 0
        ];

        if ($this->is_open_saturday === 1) {
            $saturday = [
                "is_open" => 1,
                "open" => $this->start_time_saturday,
                "close" => $this->close_time_saturday
            ];
        }

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'location_name' => $this->location_name,
            'by_line' => $this->by_line,
            'location_description' => $this->location_description,
            'location_address' => $this->location_address,
            'website' => $this->website,
            'email_id' => $this->email_id,
            'phone_number' => $this->phone_number,
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twitter_url,
            'instagram_url' => $this->instagram_url,
            'youtube_url' => $this->youtube_url,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'category_id' => $this->category_id,
            'is_active' => $this->is_active,
            'map_changed' => $this->map_changed,
            'notes' => $this->notes,
            'created_date' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'modified_date' => $this->updated_at,
            'is_open_wednesday' => $this->is_open_wednesday,

            'category_name' => CategoryResource::collection($this->categories),

            'opening_hours' => [
                'sunday' => $sunday,
                'monday' => $monday,
                'tuesday' => $tuesday,
                'wednesday' => $wednesday,
                'thursday' => $thrusday,
                'friday' => $friday,
                'saturday' => $saturday,
            ],

            "location_gallery" => LocationGalleryResource::collection($this->location_gallery),
        ];
    }
}
