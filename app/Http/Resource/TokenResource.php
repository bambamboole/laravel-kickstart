<?php declare(strict_types=1);

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Sanctum\PersonalAccessToken;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Token',
    properties: [
        new OA\Property(property: 'id', type: 'integer'),
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(property: 'abilities', type: 'array', items: new OA\Items(type: 'string', example: 'info')),
        new OA\Property(property: 'last_used_at', type: 'datetime', nullable: true),
    ],
    type: 'object',
    additionalProperties: false,
)]
class TokenResource extends JsonResource
{
    /** @var PersonalAccessToken */
    public $resource;

    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'abilities' => $this->resource->abilities,
            'last_used_at' => $this->resource->last_used_at,
        ];
    }
}
