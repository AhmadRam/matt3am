<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends BaseController
{

    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(
        protected UserRepository $userRepository
    ) {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/dashboard/users/index",
     *     operationId="getUsers",
     *     tags={"Users"},
     *     summary="Get list of users",
     *     description="Returns a list of users with pagination.",
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
     *         description="List of users",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Users retrieved successfully."),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User")),
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

        $users = $this->userRepository->paginate($limit);

        return $this->sendResponse((UserResource::class)::collection($users), 'Users retrieved successfully.');
    }

   /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/dashboard/users/show/{id}",
     *     operationId="getUserById",
     *     tags={"Users"},
     *     summary="Get user by ID",
     *     description="Returns the details of a specific user.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User retrieved successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
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
        $user = $this->userRepository->find($id);

        if (!$user) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
    }

  /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/dashboard/users/create",
     *     operationId="createUser",
     *     tags={"Users"},
     *     summary="Create a new user",
     *     description="Creates a new user.",
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
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Currency Exchange created successfully."),
     *             @OA\Property(property="result", ref="#/components/schemas/User")
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
            'status' => 'required|string',
            'restaurant_id' => 'required|integer',
        ]);

        $user = $this->userRepository->create($data);

        return $this->sendResponse(new UserResource($user), 'User created successfully.');
    }

/**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/dashboard/users/update/{id}",
     *     operationId="updateUser",
     *     tags={"Users"},
     *     summary="Update user",
     *     description="Updates the user with given data.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
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
     *         description="User updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User updated successfully."),
     *             @OA\Property(property="result", ref="#/components/schemas/User")
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
            'status' => 'required|string',
            'restaurant_id' => 'required|integer',
        ]);

        $user = $this->userRepository->update($data, $id);

        return $this->sendResponse(new UserResource($user), 'User updated successfully.');
    }

/**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/dashboard/users/destroy/{id}",
     *     operationId="deleteUser",
     *     tags={"Users"},
     *     summary="Delete user",
     *     description="Deletes a user by ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User deleted successfully."),
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
        $user = $this->userRepository->delete($id);

        return $this->sendResponse(new UserResource($user), 'User deleted successfully.');
    }
}
