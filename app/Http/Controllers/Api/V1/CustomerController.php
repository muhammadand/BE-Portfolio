<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Customer\CustomerStoreRequest;
use App\Http\Requests\Api\V1\Customer\CustomerUpdateRequest;
use App\Http\Resources\Api\Customer\CustomerResource;
use App\Services\Contracts\CustomerServiceInterface;
use Illuminate\Http\JsonResponse;

class CustomerController extends BaseApiController
{
    public function __construct(protected readonly CustomerServiceInterface $customerService) {}

    public function index(): JsonResponse
    {
        // $this->authorize('view', \App\Models\Customer::class);

        $customers = $this->customerService->getFilteredCustomers(request());

        return $this->successResponse(CustomerResource::collection($customers));
    }

    public function show(int $id): JsonResponse
    {
        $customer = $this->customerService->getCustomerById($id);
        // $this->authorize('view', $customer);

        return $this->successResponse(new CustomerResource($customer));
    }

    public function store(CustomerStoreRequest $request): JsonResponse
    {
        // $this->authorize('create', \App\Models\Customer::class);

        $customer = $this->customerService->createCustomer($request->validated());

        return $this->createdResponse(new CustomerResource($customer));
    }

    public function update(CustomerUpdateRequest $request, int $id): JsonResponse
    {
        $customer = $this->customerService->getCustomerById($id);
        // $this->authorize('update', $customer);

        $customer = $this->customerService->updateCustomer($id, $request->validated());

        return $this->successResponse(new CustomerResource($customer));
    }

    public function destroy(int $id): JsonResponse
    {
        $customer = $this->customerService->getCustomerById($id);
        // $this->authorize('delete', $customer);

        $this->customerService->deleteCustomer($id);

        return $this->noContentResponse();
    }
}
