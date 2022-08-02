<?php

namespace App\Http\Controllers\Api\V1\Auth\Repositories;

use App\Contracts\Repository;
use App\Http\Controllers\Api\V1\Traits\PaginateTraits;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Class CategoryRepository
 *
 * @package App\Http\Controllers\Api\V1\Auth\Repositories
 */
class CategoryRepository implements Repository
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
     * @param Category $category
     * @param Request  $request
     */
    public function __construct(Category $category, Request $request)
    {
        $this->model = $category;
        $this->request = $request;
    }


    /**
     * @param string $orderBy
     * @param string $direction
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all(string $orderBy = 'created_at', string $direction = 'desc')
    {
        return $this->model::with('children', 'posts')
            ->orderByDesc($orderBy)
            ->paginate($this->getLimit($this->request));
    }

    /**
     * @param int $id
     * @return Category|\Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public function find(int $id)
    {
        return $this->model::withCount('children')->whereId($id)->first();
    }

    /**
     * @return bool
     */
    public function cannotHasParentCategory(Category $category)
    {
        return $category->children_count && $category->parent_id !== null;
    }

    /**
     * @param int      $parentId
     * @param Category $category
     * @return bool
     */
    public function incorrectParentIdUpdate(int $parentId, Category $category)
    {
        return $parentId === $category->id || !in_array($parentId, $this->model::rootIds());
    }

    /**
     * @param Category $category
     * @return bool
     */
    public function incorrectParentIdStore(Category $category)
    {
        return $category->parent_id !== null && !in_array($category->parent_id, Category::rootIds());
    }
}
