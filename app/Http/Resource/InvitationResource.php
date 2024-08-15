<?php declare(strict_types=1);

namespace App\Http\Resource;

use App\Models\ProjectInvitation;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Invitation',
    properties: [
        new OA\Property(property: 'uuid', type: 'string'),
        new OA\Property(property: 'email', type: 'string'),
        new OA\Property(property: 'role', ref: '#/components/schemas/Role'),
        new OA\Property(property: 'created_at', type: 'datetime'),
    ],
    type: 'object',
    additionalProperties: false,
)]
class InvitationResource extends JsonResource
{
    /** @var ProjectInvitation */
    public $resource;

    public function toArray($request)
    {
        return [
            'uuid' => $this->resource->uuid,
            'email' => $this->resource->email,
            'role' => new RoleResource($this->whenLoaded('role')),
            'created_at' => $this->resource->created_at,
        ];
    }
}
