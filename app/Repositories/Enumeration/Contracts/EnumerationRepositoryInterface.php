<?php

namespace App\Repositories\Enumeration\Contracts;

use App\Repositories\Base\Contracts\QueryableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface EnumerationRepositoryInterface extends QueryableRepositoryInterface
{
    public function getEnumerations(): Collection;

    public function getActiveEnumerations(): Collection;
}
