<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resource\MemberResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;
use Spatie\QueryBuilder\QueryBuilder;

class MembersApiController
{
    #[OA\Get(
        path: '/api/v1/members',
        description: 'Get all members of the project.',
        security: [['BearerAuth' => ['members.list']]],
    )]
    #[OA\Parameter(
        name: 'filter',
        description: 'Filter members by name or email.',
        in: 'query',
        required: false,
        schema: new OA\Schema(
            properties: [
                new OA\Property('uuid', type: 'string', example: '123e4567-e89b-12d3-a456-426614174000'),
                new OA\Property('name', type: 'string', example: 'John Doe'),
                new OA\Property('email', type: 'string', example: 'john@example.com'),
            ],
            type: 'object',
        ),
        style: 'deepObject',
    )]
    #[OA\Parameter(ref: '#/components/parameters/Page')]
    #[OA\Parameter(ref: '#/components/parameters/PerPage')]
    #[OA\Response(
        response: '200',
        description: 'Paginated list of members',
        content: new OA\JsonContent(
            properties: [
                new OA\Property('data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Member')),
                new OA\Property('meta', ref: '#/components/schemas/Pagination'),
            ],
        )
    )]
    #[OA\Response(ref: '#/components/responses/401', response: '401')]
    #[OA\Response(ref: '#/components/responses/403', response: '403')]
    public function index(Request $request): JsonResource
    {
        $members = QueryBuilder::for($request->project()->members())
            ->allowedFilters(['uuid', 'name', 'email'])
            ->paginate(min($request->integer('per_page', 15), 100));

        return MemberResource::collection($members);
    }

    #[OA\Delete(
        path: '/api/v1/members/{uuid}',
        description: 'Remove member from project.',
        security: [['BearerAuth' => ['members.remove']]],
    )]
    #[OA\Parameter(
        name: 'uuid',
        description: 'The member resource identifier.',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'string', example: '123e4567-e89b-12d3-a456-426614174000'),
    )]
    #[OA\Response(
        response: '200',
        description: 'No content',
    )]
    #[OA\Response(
        response: '422',
        description: 'Failed validation',
        content: new OA\JsonContent(
            properties: [
                new OA\Property('message', type: 'string', example: 'Cannot remove owner from the project'),
            ],
        )
    )]
    #[OA\Response(ref: '#/components/responses/401', response: '401')]
    #[OA\Response(ref: '#/components/responses/403', response: '403')]
    public function delete(Request $request, string $uuid): Response|JsonResponse
    {
        $member = $request->project()->members()->where('uuid', $uuid)->firstOrFail();
        if ($member->pivot->role->name === 'owner') {
            // @TODO: Implement a more sophisticated policy which member can be removed maybe ?
            return response()->json(['message' => 'Cannot remove owner from the project'], 422);
        }
        $request->project()->members()->detach($member);

        return response()->noContent(200);
    }
}
