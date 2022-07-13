<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InternshipPlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'districts' => $this->districts,
            'city' => $this->city,
            'mentor' => $this->mentor,
            'phone' => $this->phone,        
            'quota' => $this->quota,    
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
