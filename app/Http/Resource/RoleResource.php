<?php declare(strict_types=1);

namespace App\Http\Resource;

use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;

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
