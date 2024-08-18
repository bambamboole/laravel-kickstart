<?php declare(strict_types=1);

namespace App\Http\Resource;

use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Role',
    properties: [
        new OA\Property(property: 'uuid', type: 'string'),
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(property: 'permissions', type: 'array', items: new OA\Items(type: 'string', example: 'project.delete')),
    ],
    type: 'object',
    additionalProperties: false,
)]
class RoleResource extends JsonResource
{
    /** @var Role */
    public $resource;

    public function toArray($request)
    {
        return [
            'uuid' => $this->resource->uuid,
            'name' => $this->resource->name,
            'permissions' => $this->resource->permissions,
        ];
    }
}
