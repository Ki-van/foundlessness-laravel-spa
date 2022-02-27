<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id' => $this->id,
            'body' => $this->body,
            'user' => $this->user,
            'marks' => MarkResource::collection($this->marks),
            'replies' => CommentResource::collection($this->replies),
            'created_at' => (new DateTime($this->created_at))->format("Y-m-d h:m"),
            'updated_at' => (new DateTime($this->updated_at))->format("Y-m-d h:m"),
        ];
    }
}
