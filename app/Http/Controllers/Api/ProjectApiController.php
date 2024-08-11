<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;
use OpenApi\Attributes as OA;

#[OA\Info(title: "My First API", version: "0.1")]
class ProjectApiController
{
    #[OA\Get(path: '/api/v1/info')]
    #[OA\Response(
        response: '200',
        description: 'The data',
        content: new OA\MediaType(
            'application/json',
            new OA\Schema(type: 'object', properties: [new OA\Property('data', ref: '#/components/schemas/Project')])
        )
    )]
    public function __invoke() {}
}
