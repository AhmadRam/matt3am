<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Requests\RestaurantRequest;
use App\Http\Resources\RestaurantResource;
use App\Repositories\RestaurantRepository;
use Illuminate\Http\Request;

class RestaurantController extends BaseController
{

    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(
        protected RestaurantRepository $restaurantRepository
    ) {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/dashboard/restaurants/index",
     *     operationId="getRestaurants",
     *     tags={"Restaurants"},
     *     summary="Get list of restaurants",
     *     description="Returns a list of restaurants with pagination.",
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
     *         description="List of restaurants",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Restaurants retrieved successfully."),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Restaurant")),
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

        $restaurants = $this->restaurantRepository->paginate($limit);

        return $this->sendResponse((RestaurantResource::class)::collection($restaurants), 'Restaurants retrieved successfully.', true);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/dashboard/restaurants/show/{id}",
     *     operationId="getRestaurantById",
     *     tags={"Restaurants"},
     *     summary="Get customer by ID",
     *     description="Returns the details of a specific customer.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Restaurant ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurant details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Restaurant retrieved successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Restaurant")
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
        $restaurant = $this->restaurantRepository->find($id);

        if (!$restaurant) {
            return $this->sendError('Restaurant not found.');
        }

        return $this->sendResponse(new RestaurantResource($restaurant), 'Restaurant retrieved successfully.');
    }

    /**
     * @OA\Post(
     *     path="/dashboard/restaurants/create",
     *     operationId="createRestaurant",
     *     tags={"Restaurants"},
     *     summary="Create a new restaurant",
     *     description="Creates a new restaurant with translations",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                     @OA\Schema(ref="#/components/schemas/Restaurant"),
     *                     @OA\Schema(
     *                         @OA\Property(
     *                             property="translations[en][logo]",
     *                             type="string",
     *                             format="binary"
     *                         ),
     *                         @OA\Property(
     *                             property="translations[ar][logo]",
     *                             type="string",
     *                             format="binary"
     *                         )
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Restaurant created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Restaurant")
     *     )
     * )
     */
    public function create(RestaurantRequest $request)
    {
        $data = $request->all();

        $restaurant = $this->restaurantRepository->create($data);

        return $this->sendResponse(new RestaurantResource($restaurant), 'Restaurant created successfully.');
    }

    /**
     * @OA\Put(
     *     path="/dashboard/restaurants/update/{id}",
     *     operationId="updateRestaurant",
     *     tags={"Restaurants"},
     *     summary="Update restaurant",
     *     description="Updates restaurant with translations",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                     @OA\Schema(ref="#/components/schemas/Restaurant"),
     *                     @OA\Schema(
     *                         @OA\Property(
     *                             property="translations[en][logo]",
     *                             type="string",
     *                             format="binary"
     *                         ),
     *                         @OA\Property(
     *                             property="translations[ar][logo]",
     *                             type="string",
     *                             format="binary"
     *                         )
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurant updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Restaurant")
     *     )
     * )
     */
    public function update(RestaurantRequest $request, $id)
    {
        $data = $request->all();

        $restaurant = $this->restaurantRepository->update($data, $id);

        return $this->sendResponse(new RestaurantResource($restaurant), 'Restaurant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/dashboard/restaurants/destroy/{id}",
     *     operationId="deleteRestaurant",
     *     tags={"Restaurants"},
     *     summary="Delete restaurant",
     *     description="Deletes a restaurant by ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Restaurant ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurant deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Restaurant deleted successfully."),
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
        $this->restaurantRepository->delete($id);

        return $this->sendResponse([], 'Restaurant deleted successfully.');
    }
}
