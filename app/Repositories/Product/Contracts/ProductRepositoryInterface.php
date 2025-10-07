<?php

namespace App\Repositories\Product\Contracts;

use App\Repositories\Base\Contracts\QueryableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface extends QueryableRepositoryInterface
{
    public function getProducts(): Collection;

    public function getActiveProducts(): Collection;

    /**
     * Import data produk dari Google Spreadsheet ke database
     *
     * @param string $spreadsheetId  ID dari Google Sheet
     * @param string $range          Rentang data (misal: 'Sheet1!A1:G100')
     * @return void
     */
    // public function importFromGoogleSheet(string $spreadsheetId, string $range): void;
}
