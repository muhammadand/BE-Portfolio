<?php

namespace App\Repositories\Vendor\Contracts;

use App\Repositories\Base\Contracts\QueryableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface VendorRepositoryInterface extends QueryableRepositoryInterface
{
    /**
     * Return All Vendors
     */
    public function getVendors(): Collection;
}
