<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Product\CreateProductRequest;
use App\Http\Requests\Api\V1\Product\UpdateProductRequest;
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

    public function index(): JsonResponse
    {
        // policy: viewAny
        $this->authorize('viewAny', Product::class);

        $products = $this->service->getProducts();
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
