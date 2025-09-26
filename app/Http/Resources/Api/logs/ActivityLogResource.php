<?php

namespace App\Http\Resources\Api\logs;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'log_name'    => $this->log_name,
            'description' => $this->description,
            'subject_type'=> $this->subject_type,
            'subject_id'  => $this->subject_id,
            'properties'  => $this->properties,
            'causer'      => $this->whenLoaded('causer', function () {
                return [
                    'id'    => $this->causer->id,
                    'name'  => $this->causer->name,
                    'email' => $this->causer->email,
                ];
            }),
            'created_at'  => $this->created_at,
        ];
    }
}
