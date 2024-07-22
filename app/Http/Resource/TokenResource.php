<?php declare(strict_types=1);

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Sanctum\PersonalAccessToken;

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
