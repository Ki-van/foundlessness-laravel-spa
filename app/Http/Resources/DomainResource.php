<?php

namespace App\Http\Resources;

use App\Models\ArticleStatus;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

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
            'articles' => $this->articles()->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('versions')
                    ->whereRaw('versions.article_id = articles.id')
                    ->where('versions.version_status_id', ArticleStatus::PUBLISHED_ID);
            })->get('id')
        ];
    }
}
