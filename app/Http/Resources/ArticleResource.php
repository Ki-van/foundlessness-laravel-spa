<?php

namespace App\Http\Resources;

use App\Models\ArticleStatus;
use App\Models\Comment;
use App\Models\Domain;
use App\Models\User;
use App\Models\Version;
use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
            'user' => $this->user,
            'tags' => $this->tags,
            'domain' => $this->domain,
            'versions' =>  $this->when(Auth::id() === $this->user_id, VersionMiniResource::collection($this->versions()->get(['id','semver'])),
                VersionMiniResource::collection($this->versions()->where('version_status_id', ArticleStatus::PUBLISHED_ID)->get(['id', 'semver']))),
            'latest_public_version' =>  new VersionResource($this->latestVersion()),
            'latest_version' => $this->when(Auth::id() === $this->user_id, new VersionResource($this->latestVersion(null))),
            'slug' => $this->slug,
            'created_at' => (new DateTime($this->created_at))->format("Y-m-d"),
            'updated_at' => (new DateTime($this->updated_at))->format("Y-m-d"),
        ];
    }
}
