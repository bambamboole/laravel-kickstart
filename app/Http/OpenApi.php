<?php declare(strict_types=1);

namespace App\Http;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Pagination',
    properties: [
        new OA\Property(property: 'current_page', type: 'integer'),
        new OA\Property(property: 'from', type: 'integer'),
        new OA\Property(property: 'path', type: 'string'),
        new OA\Property(property: 'per_page', type: 'integer'),
        new OA\Property(property: 'last_page', type: 'integer'),
        new OA\Property(property: 'to', type: 'integer'),
        new OA\Property(property: 'total', type: 'integer'),
        new OA\Property(property: 'links', type: 'array', items: new OA\Items(type: 'object')),
    ],
    type: 'object',
    additionalProperties: false,
)]

#[OA\OpenApi(
    security: [['BearerAuth' => []]]
)]
#[OA\Components(
    responses: [
        new OA\Response(
            response: '401',
            description: 'Unauthorized',
        ),
        new OA\Response(
            response: '403',
            description: 'Unauthorized',
        ),
        new OA\Response(
            response: '422',
            description: 'Failed validation',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property('message', type: 'string',
                        example: 'The email is required (and 1 more error)',
                    ),
                    new OA\Property('errors', type: 'object',
                        example: [
                            'email' => ['The email is required'],
                            'role_uuid' => ['The role is required'],
                        ],
                    ),
                ],
            )
        ),
    ],
    parameters: [
        new OA\Parameter(
            parameter: 'Page',
            name: 'page',
            description: 'Page number.',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'integer'),
            example: 1,
        ),
        new OA\Parameter(
            parameter: 'PerPage',
            name: 'per_page',
            description: 'Page size.',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'integer'),
            example: 30,
        ),
    ],
    securitySchemes: [
        new OA\SecurityScheme(
            securityScheme: 'BearerAuth',
            type: 'http',
            in: 'header',
            scheme: 'bearer',
        ),
    ]
)]
abstract class OpenApi
{
    // @TODO: Is this the right place for this? Should we extend the OpenAPI generator to automatically inject this?
}
