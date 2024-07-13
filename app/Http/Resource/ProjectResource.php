<?php declare(strict_types=1);

namespace App\Http\Resource;

use App\Models\Project;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /** @var Project */
    public $resource;

    public function toArray($request)
    {
        return [
            'uuid' => $this->resource->uuid,
            'name' => $this->resource->name,
            'members' => MemberResource::collection($this->whenLoaded('members')),
            'invitations' => InvitationResource::collection($this->whenLoaded('invitations')),
        ];
    }
}
