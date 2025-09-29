<?php

namespace App\Repositories\ProductCategory\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Base\Contracts\QueryableRepositoryInterface;

interface ProductCategoryRepositoryInterface extends QueryableRepositoryInterface
{
    /**
     * Ambil semua product categories dengan dukungan filter, sort, include, dsb.
     */
    public function getProductCategories(): Collection;
}
