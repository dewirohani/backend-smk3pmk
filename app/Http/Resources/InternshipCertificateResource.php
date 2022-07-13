<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InternshipCertificateResource extends JsonResource
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
            'name' => $this->name,             
            'path' => $this->path,             
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
