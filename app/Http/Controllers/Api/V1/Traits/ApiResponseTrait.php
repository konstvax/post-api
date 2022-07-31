<?php

namespace App\Http\Controllers\Api\V1\Traits;

use Illuminate\Http\Resources\Json\JsonResource;

trait ApiResponseTrait
{
    /**
     * @param array $additional
     * @param int   $statusCode
     * @return \Illuminate\Http\JsonResponse|object
     */
    protected function dataNotFoundResponse(array $additional = [], int $statusCode = 404)
    {
        $data = ['message' => 'data not found'];

        $data = array_merge($additional, $data);

        return JsonResource::make(collect())->additional($data)->response()
            ->setStatusCode($statusCode);
    }
}
