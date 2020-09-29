<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Booking extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'checkin' => null,
            'checkout' => null,
            'room_id' => $this->room_id,
            'type_id' => $this->type_id,
            'beds' => $this->beds,
            'type_name' => $this->name,
          ];
    }
}
