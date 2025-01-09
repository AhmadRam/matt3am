<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Repositories\CustomerGroupRepository;
use Illuminate\Http\Request;

class CustomerGroupController extends BaseController
{

    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(
        protected CustomerGroupRepository $customerGroupRepository
    ) {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/dashboard/customer-groups/index",
     *     operationId="getCustomerGroups",
     *     tags={"CustomerGroups"},
     *     summary="Get list of customer groups",
     *     description="Returns a list of customer groups with pagination.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Limit number of results",
     *         required=false,
     *         @OA\Schema(type="integer", example=12)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of customer groups",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Customer Groups retrieved successfully."),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/CustomerGroup")),
     *             @OA\Property(property="total_results", type="integer", example=50),
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="last_page", type="integer", example=5),
     *             @OA\Property(property="next_page", type="integer", example=2),
     *             @OA\Property(property="previous_page", type="integer", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Internal server error"),
     *             @OA\Property(property="result", type="object", example={})
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit', 12);

        $customerGroups = $this->customerGroupRepository->paginate($limit);

        return $this->sendResponse($customerGroups, 'Customer Groups retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/dashboard/customer-groups/show/{id}",
     *     operationId="getCustomerGroupById",
     *     tags={"CustomerGroups"},
     *     summary="Get customer by ID",
     *     description="Returns the details of a specific customer.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Customer Group ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer Group details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Customer Group retrieved successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerGroup")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Internal server error"),
     *             @OA\Property(property="result", type="object", example={})
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $customerGroup = $this->customerGroupRepository->find($id);

        if (is_null($customerGroup)) {
            return $this->sendError('Customer Group not found.');
        }

        return $this->sendResponse($customerGroup, 'Customer Group retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/dashboard/customer-groups/create",
     *     operationId="createCustomerGroup",
     *     tags={"CustomerGroups"},
     *     summary="Create a new customer Group",
     *     description="Creates a new customer Group.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"base_currency", "target_currency", "rate"},
     *             @OA\Property(property="base_currency", type="integer", example=1),
     *             @OA\Property(property="target_currency", type="integer", example=2),
     *             @OA\Property(property="rate", type="number", format="float", example=1.23)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Customer Group created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Currency Exchange created successfully."),
     *             @OA\Property(property="result", ref="#/components/schemas/CustomerGroup")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Internal server error"),
     *             @OA\Property(property="result", type="object", example={})
     *         )
     *     )
     * )
     */
    public function create()
    {
        $data = request()->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $customerGroup = $this->customerGroupRepository->create($data);

        return $this->sendResponse($customerGroup, 'Customer Group created successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/dashboard/customer-groups/update/{id}",
     *     operationId="updateCustomerGroup",
     *     tags={"CustomerGroups"},
     *     summary="Update customer Group",
     *     description="Updates the customer Group with given data.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Customer Group ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"base_currency", "target_currency", "rate"},
     *             @OA\Property(property="base_currency", type="integer", example=1),
     *             @OA\Property(property="target_currency", type="integer", example=2),
     *             @OA\Property(property="rate", type="number", format="float", example=1.23)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer Group updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Customer Group updated successfully."),
     *             @OA\Property(property="result", ref="#/components/schemas/CustomerGroup")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Internal server error"),
     *             @OA\Property(property="result", type="object", example={})
     *         )
     *     )
     * )
     */
    public function update($id)
    {
        $data = request()->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $customerGroup = $this->customerGroupRepository->update($data, $id);

        return $this->sendResponse($customerGroup, 'Customer Group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/dashboard/customer-groups/destroy/{id}",
     *     operationId="deleteCustomerGroup",
     *     tags={"CustomerGroups"},
     *     summary="Delete customer Group",
     *     description="Deletes a customer Group by ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Customer Group ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer Group deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Customer Group deleted successfully."),
     *             @OA\Property(property="result", type="object", example={})
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Internal server error"),
     *             @OA\Property(property="result", type="object", example={})
     *         )
     *     )
     * )
     */
    public function delete($id)
    {
        $customerGroup = $this->customerGroupRepository->delete($id);

        return $this->sendResponse($customerGroup, 'Customer Group deleted successfully.');
    }
}
