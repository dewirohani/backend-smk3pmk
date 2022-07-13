<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PeriodResource extends JsonResource
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
            'nama_periode' => $this->nama_periode,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,        
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
