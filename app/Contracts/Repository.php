<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface Repository
{
    /**
     * @param string $orderBy
     * @param string $direction
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all(string $orderBy, string $direction);

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public function find(int $id);
}
