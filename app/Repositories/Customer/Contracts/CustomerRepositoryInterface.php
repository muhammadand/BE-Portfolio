<?php

namespace App\Repositories\Customer\Contracts;

use App\Repositories\Base\Contracts\QueryableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface CustomerRepositoryInterface extends QueryableRepositoryInterface
{
    public function getCustomers(): Collection;

    public function getActiveCustomers(): Collection;
}
