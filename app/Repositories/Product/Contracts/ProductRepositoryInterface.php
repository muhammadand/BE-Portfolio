<?php

namespace App\Repositories\Product\Contracts;
use App\Repositories\Base\Contracts\QueryableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface extends QueryableRepositoryInterface
{
    public function getProducts(): Collection;

    public function getActiveProducts(): Collection;
}
