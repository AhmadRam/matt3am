<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class CustomerController extends BaseController
{

    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(
        protected CustomerRepository $customerRepository
    ) {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/dashboard/customers/index",
     *     operationId="getCustomers",
     *     tags={"Customers"},
     *     summary="Get list of customers",
     *     description="Returns a list of customers with pagination.",
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
     *         description="List of customers",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Customers retrieved successfully."),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Customer")),
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

        $customers = $this->customerRepository->paginate($limit);

        return $this->sendResponse($customers, 'Customers retrieved successfully.', true);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/dashboard/customers/show/{id}",
     *     operationId="getCustomerById",
     *     tags={"Customers"},
     *     summary="Get customer by ID",
     *     description="Returns the details of a specific customer.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Customer ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Customer retrieved successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Customer")
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
        $customer = $this->customerRepository->find($id);

        if (is_null($customer)) {
            return $this->sendError('Customer not found.');
        }

        return $this->sendResponse($customer, 'Customer retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/dashboard/customers/create",
     *     operationId="createCustomer",
     *     tags={"Customers"},
     *     summary="Create a new customer",
     *     description="Creates a new customer.",
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
     *         description="Customer created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Currency Exchange created successfully."),
     *             @OA\Property(property="result", ref="#/components/schemas/Customer")
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
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
        ]);

        $customer = $this->customerRepository->create($data);

        return $this->sendResponse($customer, 'Customer created successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/dashboard/customers/update/{id}",
     *     operationId="updateCustomer",
     *     tags={"Customers"},
     *     summary="Update customer",
     *     description="Updates the customer with given data.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Customer ID",
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
     *         description="Customer updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Customer updated successfully."),
     *             @OA\Property(property="result", ref="#/components/schemas/Customer")
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
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
        ]);

        $customer = $this->customerRepository->update($data, $id);

        return $this->sendResponse($customer, 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/dashboard/customers/destroy/{id}",
     *     operationId="deleteCustomer",
     *     tags={"Customers"},
     *     summary="Delete customer",
     *     description="Deletes a customer by ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Customer ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Customer deleted successfully."),
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
    public function destroy($id)
    {
        $customer = $this->customerRepository->delete($id);

        return $this->sendResponse($customer, 'Customer deleted successfully.');
    }
}
