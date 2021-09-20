<?php

namespace App\Http\Resources;

use App\Models\Comment;
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
    {   #TODO: poprawić, coś z softdeletes
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'descr'        => $this->descr,
            'category'     => $this->category->value,
            'created_at'   => $this->created_at,
            'status'       => $this->status->state,
            'priority'     => $this->priority->state,
            'color'        => $this->priority->color,
            'user'         => $this->user->name,
            'user_id'      => $this->user->id,
            'files'        => $this->files,
            'comments'     => CommentResource::collection($this->whenLoaded('comments')->sortByDesc('created_at'))
        ];
    }
}
