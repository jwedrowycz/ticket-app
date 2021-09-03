<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'id'           => $this->id,
            'title'        => $this->title,
            'descr'        => $this->descr,
            'created_at'   => $this->created_at,
            'status'       => $this->status->state,
            'priority'     => $this->priority->state,
            'color'        => $this->priority->color,
            'user'         => $this->user->name,
            'files'        => $this->files
        ];
    }
}
