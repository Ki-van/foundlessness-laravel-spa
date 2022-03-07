<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class VersionResource extends JsonResource
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
            'heading' => $this->heading,
            'description' => $this->description,
            'body' => $this->body,
            'comments' => CommentResource::collection($this->comments),
            'marks' => MarkResource::collection($this->marks),
            'semver' => (string) $this->semver,
            'status' => $this->status,
            'created_at' => (new DateTime($this->created_at))->format("Y-m-d"),
            'updated_at' => (new DateTime($this->updated_at))->format("Y-m-d"),
        ];
    }
}
