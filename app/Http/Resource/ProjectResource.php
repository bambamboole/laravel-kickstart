<?php declare(strict_types=1);

namespace App\Http\Resource;

use App\Models\Project;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Project',
    required: ['uuid', 'name'],
    properties: [
        new OA\Property(property: 'uuid', type: 'string'),
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(property: 'members', type: 'array', items: new OA\Items(ref: '#/components/schemas/Member')),
        new OA\Property(property: 'tokens', type: 'array', items: new OA\Items(ref: '#/components/schemas/Token')),
        new OA\Property(property: 'invitations', type: 'array', items: new OA\Items(ref: '#/components/schemas/Token')),
    ],
    type: 'object',
    additionalProperties: false,
)]
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
            'tokens' => TokenResource::collection($this->whenLoaded('tokens')),
        ];
    }
}
