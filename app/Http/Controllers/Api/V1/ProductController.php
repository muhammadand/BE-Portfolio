<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\Concretes\GoogleSheetService;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Product\CreateProductRequest;
use App\Http\Requests\Api\V1\Product\UpdateProductRequest;
use App\Http\Requests\Api\V1\Product\ImportFromSpreadsheetRequest;
use App\Http\Resources\Api\Product\ProductResource;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Http\JsonResponse;
use App\Models\Product;



class ProductController extends BaseApiController
{
    protected ProductServiceInterface $service;

    public function __construct(ProductServiceInterface $service)
    {
        $this->service = $service;
    }

    // public function importFromSpreadsheet(ImportFromSpreadsheetRequest $request): JsonResponse
    // {
    //     $spreadsheetId = $request->input('spreadsheet_id');
    //     $range = $request->input('range', 'MM!A1:F10');
    //     try {
    //         $sheetService = new GoogleSheetService($spreadsheetId);
    //         $rows = $sheetService->getSheetData($range);
    //         if (empty($rows)) {
    //             return response()->json(['message' => 'Data kosong atau tidak ditemukan pada range yang diberikan.', 'spreadsheet_id' => $spreadsheetId, 'range' => $range, 'rows_count' => 0, 'rows' => [],]);
    //         }
    //         return response()->json(['message' => 'Data berhasil diambil dari Google Sheet.', 'spreadsheet_id' => $spreadsheetId, 'range' => $range, 'rows_count' => count($rows), 'rows' => $rows,]);
    //     } catch (\Throwable $e) {
    //         \Log::error('Gagal membaca data dari Google Sheet', ['error' => $e->getMessage(), 'spreadsheet_id' => $spreadsheetId, 'range' => $range,]);
    //         return response()->json(['error' => 'Gagal membaca data dari Google Sheet', 'message' => $e->getMessage(),], 500);
    //     }
    // }


    public function importFromSpreadsheet(ImportFromSpreadsheetRequest $request): JsonResponse
    {
        $spreadsheetId = $request->input('spreadsheet_id');
        $range = $request->input('range', 'FM!A1:F100');
    
        try {
            $products = $this->service->importFromSpreadsheet($spreadsheetId, $range);
            return $this->createdResponse(
                ProductResource::collection($products),
                'Data produk berhasil diimport dari Google Sheet.'
            );
        } catch (\Throwable $e) {
            \Log::error('Gagal import data produk', [
                'error' => $e->getMessage(),
                'spreadsheet_id' => $spreadsheetId,
                'range' => $range,
            ]);
            return $this->errorResponse('Gagal import data produk: ' . $e->getMessage(), 500);
        }
    }
    
    
    





    public function index(): JsonResponse
    {
        $this->authorize('viewAny', \App\Models\Product::class);

        $products = $this->service->getFilteredProducts(request());

        return $this->successResponse(ProductResource::collection($products));
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->service->getProductById($id);

        // policy: view
        $this->authorize('view', $product);

        return $this->successResponse(new ProductResource($product));
    }

    public function store(CreateProductRequest $request): JsonResponse
    {
        // policy: create
        $this->authorize('create', Product::class);

        $product = $this->service->createProduct($request->validated());
        return $this->createdResponse(new ProductResource($product));
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $product = $this->service->getProductById($id);

        // policy: update
        $this->authorize('update', $product);

        $product = $this->service->updateProduct($id, $request->validated());
        return $this->successResponse(new ProductResource($product));
    }

    public function destroy(int $id): JsonResponse
    {
        $product = $this->service->getProductById($id);

        // policy: delete
        $this->authorize('delete', $product);

        $this->service->deleteProduct($id);
        return $this->noContentResponse();
    }
}
