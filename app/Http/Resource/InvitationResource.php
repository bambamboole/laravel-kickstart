<?php declare(strict_types=1);

namespace App\Http\Resource;

use App\Models\ProjectInvitation;
use Illuminate\Http\Resources\Json\JsonResource;

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
