<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\ProductCategory\ProductCategoryStoreRequest;
use App\Http\Requests\Api\V1\ProductCategory\ProductCategoryUpdateRequest;
use App\Http\Resources\Api\Category\ProductCategoryResource;
use App\Services\Contracts\ProductCategoryServiceInterface;
use Illuminate\Http\JsonResponse;

class ProductCategoryController extends BaseApiController
{
    public function __construct(
        protected readonly ProductCategoryServiceInterface $productCategoryService
    ) {}

    public function index(): JsonResponse
    {
        $this->authorize('view', \App\Models\ProductCategory::class);

        $categories = $this->productCategoryService->getFilteredCategories(request()->all());

        return $this->successResponse(ProductCategoryResource::collection($categories));
    }

    public function show(int $id): JsonResponse
    {
        $this->authorize('view', \App\Models\ProductCategory::class);

        $category = $this->productCategoryService->getCategoryById($id);

        return $this->successResponse(new ProductCategoryResource($category));
    }

    public function store(ProductCategoryStoreRequest $request): JsonResponse
    {
        $this->authorize('create', \App\Models\ProductCategory::class);

        $category = $this->productCategoryService->createCategory($request->validated());

        return $this->createdResponse(new ProductCategoryResource($category));
    }

    public function update(ProductCategoryUpdateRequest $request, int $id): JsonResponse
    {
        $this->authorize('update', \App\Models\ProductCategory::class);

        $category = $this->productCategoryService->updateCategory($id, $request->validated());

        return $this->successResponse(new ProductCategoryResource($category));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->authorize('delete', \App\Models\ProductCategory::class);

        $this->productCategoryService->deleteCategory($id);

        return $this->noContentResponse();
    }
}
