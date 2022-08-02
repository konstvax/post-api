<?php

namespace App\Http\Controllers\Api\V1\Auth\Repositories;

use App\Contracts\Repository;
use App\Http\Controllers\Api\V1\Traits\PaginateTraits;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class PostRepository
 *
 * @package App\Http\Controllers\Api\V1\Auth\Repositories
 */
class PostRepository implements Repository
{
    use PaginateTraits;

    /**
     * @var Model
     */
    private $model;

    /**
     * @var Request
     */
    private $request;

    /**
     * @param Post    $post
     * @param Request $request
     */
    public function __construct(Post $post, Request $request)
    {
        $this->model = $post;
        $this->request = $request;
    }


    /**
     * @param string $orderBy
     * @param string $direction
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all(string $orderBy = 'created_at', string $direction = 'desc')
    {
        return $this->model::orderBy($orderBy, $direction)
            ->paginate($this->getLimit($this->request));
    }

    /**
     * @param int $id
     * @return Post|\Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public function find(int $id)
    {
        return $this->model::whereId($id)->first();
    }

    /**
     * @param Request $postRequest
     * @param string  $requestKey
     * @return false|string
     */
    public function uploadImage(Request $postRequest, string $requestKey = 'image')
    {
        if ($postRequest->hasFile($requestKey)) {
            $file = $postRequest->file($requestKey);
            // Filename to store
            $fileNameToStore = Str::random(20) . '_' . time() . '.' . $file->getClientOriginalExtension();

            return $file->storeAs('public/posts', $fileNameToStore) ? $fileNameToStore : false;
        }

        return false;
    }
}
