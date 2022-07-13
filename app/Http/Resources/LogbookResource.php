<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogbookResource extends JsonResource
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
            'teacher_id' => $this->teacher->name,
            'date_of_logbook' => $this->date_of_logbook,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,   
            'activity' => $this->activity,        
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
