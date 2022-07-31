<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Resources\V1\CategoryResource;

/**
 * Class CategoryController
 *
 * @package App\Http\Controllers\Api\V1
 */
class CategoryController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param string $slug
     * @return CategoryResource|\Illuminate\Http\JsonResponse|object
     */
    public function __invoke(string $slug)
    {
        $category = Category::whereSlug($slug)
            ->with(['children', 'posts'])
            ->first();

        if (null === $category) {
            return $this->dataNotFoundResponse();
        }

        return new CategoryResource($category);
    }
}
