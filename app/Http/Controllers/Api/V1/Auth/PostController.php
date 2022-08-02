<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Auth\Repositories\PostRepository;
use App\Http\Controllers\Api\V1\Traits\ApiResponseTrait;
use App\Http\Controllers\Api\V1\Traits\PaginateTraits;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\PostRequest;
use App\Models\Post;
use App\Resources\V1\PostResource;

/**
 * Class PostController
 *
 * @package App\Http\Controllers\Api\V1\Auth
 */
class PostController extends Controller
{
    use PaginateTraits;
    use ApiResponseTrait;

    /**
     * @var PostRepository
     */
    public $repository;

    public function __construct(PostRepository $postRepository)
    {
        $this->repository = $postRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|object
     */
    public function index()
    {
        $posts = $this->repository->all();

        if ($posts->isEmpty()) {
            return $this->dataNotFoundResponse();
        }

        return PostResource::collection($posts);
    }

    /**
     * @param int $id
     * @return PostResource|\Illuminate\Http\JsonResponse|object
     */
    public function show(int $id)
    {
        $post = $this->repository->find($id);

        if (null === $post) {
            return $this->dataNotFoundResponse();
        }

        return new PostResource($post);
    }

    /**
     * @param PostRequest $postRequest
     * @param int         $id
     * @return \Illuminate\Http\JsonResponse|object|void
     */
    public function update(PostRequest $postRequest, int $id)
    {
        $post = $this->repository->find($id);

        if (null === $post) {
            return $this->dataNotFoundResponse();
        }

        $post->fill($postRequest->validated());

        if ($fileNameToStore = $this->repository->uploadImage($postRequest)) {
            $post->deleteImage();
            $post->image = $fileNameToStore;
        }

        $post->update();

        return new PostResource($post);
    }

    /**
     * @param PostRequest $postRequest
     * @return PostResource
     */
    public function store(PostRequest $postRequest)
    {
        $post = new Post();

        $post->fill($postRequest->validated());

        $post->slug = $post->slug ?? \Str::slug($post->title);

        if ($fileNameToStore = $this->repository->uploadImage($postRequest)) {
            $post->image = $fileNameToStore;
        }

        $post->save();

        return new PostResource($post);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|object|void
     */
    public function softDelete(int $id)
    {
        $post = $this->repository->find($id);

        if (null === $post) {
            return $this->dataNotFoundResponse();
        }

        if ($post->delete()) {
            return $this->success();
        }

        return $this->errorResponse('Something wrong');
    }
}
