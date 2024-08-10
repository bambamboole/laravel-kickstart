<?php declare(strict_types=1);

namespace App\Http\Resource;

use App\Models\ProjectMember;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

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
