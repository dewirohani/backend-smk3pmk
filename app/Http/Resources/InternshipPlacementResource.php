<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InternshipPlacementResource extends JsonResource
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
                'id' =>                         $this->id,
                'student' =>                    $this->internshipSubmission->student->name, 
                'grade' =>                      $this->internshipSubmission->grade->name,
                'major' =>                      $this->internshipSubmission->major->name,
                'period' =>                     $this->internshipSubmission->period->nama_periode,
                'place' =>                      $this->internshipSubmission->internshipPlace->name,
                'status' =>                     $this->internshipSubmission->status,
                'teacher' =>                    $this->teacher->name,        
                'created_at' =>                 $this->created_at,
                'updated_at' =>                 $this->updated_at,
            ];
    }
}
