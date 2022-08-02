<?php

namespace App\Http\Controllers\Api\V1\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait ApiResponseTrait
{
    /**
     * @param     $data
     * @param int $statusCode
     * @return JsonResponse|object
     */
    protected function dataNotFoundResponse($data = null, int $statusCode = 404)
    {
        if (false === is_array($data)) {
            if (!$data) {
                $data = ['data not found'];
            } else {
                $data = [$data];
            }
        }

        $data = ['message' => $data];

        $data['success'] = false;
        return JsonResource::make(collect())->additional($data)->response()
            ->setStatusCode($statusCode);
    }

    /**
     * @param     $data
     * @param int $statusCode
     * @return JsonResponse|object
     */
    protected function errorResponse($data = null, int $statusCode = 200)
    {
        if (false === is_array($data)) {
            if (!$data) {
                $data = [];
            }
        }

        $data = ['message' => $data];

        $data['success'] = false;

        return JsonResource::make(collect())->additional($data)->response()
            ->setStatusCode($statusCode);
    }

    protected function success($data = null)
    {
        if (false === is_array($data)) {
            if (!$data) {
                $data = [];
            }
        }

        $data = ['message' => $data];

        $data['success'] = true;

        return JsonResource::make(collect())->additional($data)->response();
    }
}
