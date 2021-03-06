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
            'id' => $this->id,
            'checkin' => $this->checkin,
            'checkout' => $this->checkout,
            'room_id' => $this->room_id,
            'type_id' => $this->room->type_id,
            'beds' => $this->room->roomType->beds,
            'type_name' => $this->room->roomType->name,
          ];
    }
}
