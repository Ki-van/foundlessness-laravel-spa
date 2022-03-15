<?php

namespace App\Http\Resources;

use App\Models\ArticleStatus;
use DateTime;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use JsonSerializable;

class ArticleModerateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user,
            'tags' => $this->tags,
            'domain' => $this->domain,
            'versions' => VersionMiniResource::collection($this->versions()->where('version_status_id', ArticleStatus::MODERATED_ID)->get(['id', 'semver'])),
            'latest_to_moderate_version' => new VersionResource($this->latestVersion(ArticleStatus::MODERATED_ID)),
            'slug' => $this->slug,
            'created_at' => (new DateTime($this->created_at))->format("Y-m-d"),
            'updated_at' => (new DateTime($this->updated_at))->format("Y-m-d"),
        ];
    }
}
