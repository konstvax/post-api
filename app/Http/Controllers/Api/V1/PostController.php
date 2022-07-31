<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Resources\V1\PostResource;

/**
 * Class PostController
 *
 * @package App\Http\Controllers\Api\V1
 */
class PostController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse|object|void
     */
    public function __invoke(string $slug)
    {
        $post = Post::whereSlug($slug)->first();

        if (null === $post) {
            return $this->dataNotFoundResponse();
        }

        return new PostResource($post);
    }
}
