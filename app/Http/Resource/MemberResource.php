<?php declare(strict_types=1);

namespace App\Http\Resource;

use App\Models\ProjectMember;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Member',
    properties: [
        new OA\Property(property: 'uuid', type: 'string'),
        new OA\Property(property: 'email', type: 'string'),
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(property: 'last_login_at', type: 'datetime', nullable: true),
        new OA\Property(property: 'role', ref: '#/components/schemas/Role'),
    ],
    type: 'object',
    additionalProperties: false,
)]
class MemberResource extends JsonResource
{
    /** @var User */
    public $resource;

    public function toArray($request)
    {
        return [
            'uuid' => $this->resource->uuid,
            'email' => $this->resource->email,
            'name' => $this->resource->name,
            'last_login_at' => $this->resource->last_login_at,
            'role' => new RoleResource($this->whenPivotLoaded(new ProjectMember, function () {
                return $this->resource->pivot->role;
            })),
        ];
    }
}
