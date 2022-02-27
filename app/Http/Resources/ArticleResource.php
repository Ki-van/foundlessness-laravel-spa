<?php

namespace App\Http\Resources;

use App\Models\ArticleStatus;
use App\Models\Comment;
use App\Models\Domain;
use App\Models\User;
use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'user' => $this->user,
            'comments' => CommentResource::collection($this->comments),
            'marks' => MarkResource::collection($this->marks),
            'status' => $this->status,
            'tags' => $this->tags,
            'domain' => $this->domain,
            'slug' => $this->slug,
            'created_at' => (new DateTime($this->created_at))->format("Y-m-d"),
            'updated_at' => (new DateTime($this->updated_at))->format("Y-m-d"),
        ];
    }
}
