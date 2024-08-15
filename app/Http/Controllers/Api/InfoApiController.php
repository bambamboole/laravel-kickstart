<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resource\ProjectResource;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class InfoApiController
{
    #[OA\Get(path: '/api/v1/info', security: [['BearerAuth' => ['info']]])]
    #[OA\Response(
        response: '200',
        description: 'This endpoint returns information about the project, members and pending invitations.',
        content: new OA\JsonContent(
            properties: [new OA\Property('data', ref: '#/components/schemas/Project')],
            additionalProperties: false,
        )
    )]
    #[OA\Response(
        response: '403',
        description: 'Not authorized',
    )]
    public function __invoke(Request $request)
    {
        return new ProjectResource($request->project()->load(['members.pivot.role', 'invitations.role', 'tokens']));
    }
}
