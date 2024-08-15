<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resource\MemberResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;
use Spatie\QueryBuilder\QueryBuilder;

class MembersApiController
{
    #[OA\Get(
        path: '/api/v1/members',
        description: 'Get all members of the project.',
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
    #[OA\Response(
        response: '403',
        description: 'Not authorized',
    )]
    public function index(Request $request): JsonResource
    {
        $members = QueryBuilder::for($request->project()->members())
            ->allowedFilters(['uuid', 'name', 'email'])
            ->paginate();

        return MemberResource::collection($members);
    }
}
