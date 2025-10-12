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




    public function importFromSpreadsheet(): JsonResponse
    {
        // Ambil dari .env
        $spreadsheetId = env('GOOGLE_SHEET_ID');
        $range = env('GOOGLE_SHEET_RANGE', 'Upload!A3:G'); // default kalau env kosong
    
        try {
            $result = $this->service->importFromSpreadsheet($spreadsheetId, $range);
            $created = $result['created'];
            $skipped = $result['skipped'];
    
            return response()->json([
                'message' => 'Data produk berhasil diimport dari Google Sheet.',
                'total_created' => $created->count(),
                'total_skipped' => $skipped->count(),
                'skipped_items' => $skipped,
                'data' => ProductResource::collection($created),
            ], 201);
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
