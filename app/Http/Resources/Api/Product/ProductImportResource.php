<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'spreadsheet_id' => $this->spreadsheet_id,
            'range' => $this->range,
            'rows_count' => $this->rows_count,
            'rows' => $this->rows,
        ];
    }
}
