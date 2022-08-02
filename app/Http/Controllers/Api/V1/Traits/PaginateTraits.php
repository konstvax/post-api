<?php

namespace App\Http\Controllers\Api\V1\Traits;

use Illuminate\Http\Request;

trait PaginateTraits
{
    /**
     * @var int
     */
    protected $perPageLimitDefault = 10;

    /**
     * @var string
     */
    protected $paramQuery = 'per_page';

    /**
     * @param Request $request
     * @return int
     */
    protected function getLimit(Request $request): int
    {
        if ((int)$request->get($this->paramQuery) > 0) {
            return (int)$request->get($this->paramQuery);
        }

        return $this->perPageLimitDefault;
    }
}
