<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Auth\Repositories\CategoryRepository;
use App\Http\Controllers\Api\V1\Traits\ApiResponseTrait;
use App\Http\Controllers\Api\V1\Traits\PaginateTraits;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CategoryRequest;
use App\Models\Category;
use App\Resources\V1\Auth\CategoryResource;
use Illuminate\Http\Request;

/**
 * Class CategoryController
 *
 * @package App\Http\Controllers\Api\V1\Auth
 */
class CategoryController extends Controller
{
    use PaginateTraits;
    use ApiResponseTrait;

    public $repository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|object
     */
    public function index()
    {
        $category = $this->repository->all();

        if ($category->isEmpty()) {
            return $this->dataNotFoundResponse();
        }

        return CategoryResource::collection($category);
    }

    /**
     * @param int $id
     * @return CategoryResource|\Illuminate\Http\JsonResponse|object
     */
    public function show(int $id)
    {
        $category = $this->repository->find($id);

        if (null === $category) {
            return $this->dataNotFoundResponse();
        }

        return new CategoryResource($category);
    }

    /**
     * @param CategoryRequest $request
     * @param int             $id
     * @return CategoryResource|\Illuminate\Http\JsonResponse|object
     */
    public function update(CategoryRequest $request, int $id)
    {
        $category = $this->repository->find($id);

        if (null === $category) {
            return $this->dataNotFoundResponse();
        }

        $category->fill($request->validated());

        if ($this->repository->cannotHasParentCategory($category)) {
            return $this->errorResponse([
                "Root category with id = $category->id cannot have a parent category (one nesting level)."
            ]);
        }

        $parentId = $request->get('parent_id') ? (int)$request->get('parent_id') : null;

        if ($parentId) {
            if ($this->repository->incorrectParentIdUpdate($parentId, $category)) {
                return $this->errorResponse(['Incorrect data']);
            }
        }

        $category->update();

        return new CategoryResource($category);
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\Response|object
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();

        $category->fill($request->validated());

        if ($this->repository->incorrectParentIdStore($category)) {
            return $this->errorResponse('Incorrect data');
        }

        $category->slug = $category->slug ?? \Str::slug($category->title);

        $category->save();

        return new CategoryResource($category);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|object|void
     */
    public function softDelete(int $id)
    {
        $category = $this->repository->find($id);

        if (null === $category) {
            return $this->dataNotFoundResponse();
        }

        if ($category->delete()) {
            return $this->success();
        }

        return $this->errorResponse('Something wrong');
    }
}
