<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\ProductCategory\ProductCategoryStoreRequest;
use App\Http\Requests\Api\V1\ProductCategory\ProductCategoryUpdateRequest;
use App\Http\Resources\Api\Category\ProductCategoryResource;
use App\Services\Contracts\ProductCategoryServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends BaseApiController
{
    public function __construct(
        protected readonly ProductCategoryServiceInterface $productCategoryService
    ) {}

    private function checkPermission(string $permission)
    {
        $user = Auth::user();

        if (!$user || !$user->all_permissions->contains('slug', $permission)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return true;
    }

    public function index(): JsonResponse
    {
        $response = $this->checkPermission('view_product_categories');
        if ($response !== true) {
            return $response;
        }

        $categories = $this->productCategoryService->getFilteredCategories(request());

        return $this->successResponse(ProductCategoryResource::collection($categories));
    }

    public function show(int $id): JsonResponse
    {
        $response = $this->checkPermission('view_product_categories');
        if ($response !== true) {
            return $response;
        }

        $category = $this->productCategoryService->getCategoryById($id);

        return $this->successResponse(new ProductCategoryResource($category));
    }

    public function store(ProductCategoryStoreRequest $request): JsonResponse
    {
        $response = $this->checkPermission('create_product_categories');
        if ($response !== true) {
            return $response;
        }

        $category = $this->productCategoryService->createCategory($request->validated());

        return $this->createdResponse(new ProductCategoryResource($category));
    }

    public function update(ProductCategoryUpdateRequest $request, int $id): JsonResponse
    {
        $response = $this->checkPermission('edit_product_categories');
        if ($response !== true) {
            return $response;
        }

        $category = $this->productCategoryService->updateCategory($id, $request->validated());

        return $this->successResponse(new ProductCategoryResource($category));
    }

    public function destroy(int $id): JsonResponse
    {
        $response = $this->checkPermission('delete_product_categories');
        if ($response !== true) {
            return $response;
        }

        $this->productCategoryService->deleteCategory($id);

        return $this->noContentResponse();
    }
}
