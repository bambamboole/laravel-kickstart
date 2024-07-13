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
            'email' => $this->resource->email,
        ];
    }
}
