<?php

namespace App\Http\Resources;

use App\Models\ArticleStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class DomainResource extends JsonResource
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
            'description' => $this->description,
            'name' => $this->name,
            'articles' => $this->articles()->where('article_status_id', '=', ArticleStatus::PUBLISHED_ID)->get('id')
        ];
    }
}
