<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InternshipSubmissionResource extends JsonResource
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
            'student_id' => $this->student->name,
            'grade_id' => $this->grade->name,
            'major_id' => $this->major->name,
            'period_id' => $this->period->nama_periode,
            'internship_place_id' => $this->internshipPlace->name,        
            'status' => $this->status,        
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
