<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Requests\TableRequest;
use App\Http\Resources\TableResource;
use App\Repositories\TableRepository;
use Illuminate\Http\Request;

class TableController extends BaseController
{

    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(
        protected TableRepository $tableRepository
    ) {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/dashboard/tables/index",
     *     operationId="getTables",
     *     tags={"Tables"},
     *     summary="Get list of tables",
     *     description="Returns a list of tables with pagination.",
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
     *         description="List of tables",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Tables retrieved successfully."),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Table")),
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

        $tables = $this->tableRepository->paginate($limit);

        return $this->sendResponse((TableResource::class)::collection($tables), 'Tables retrieved successfully.', true);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/dashboard/tables/show/{id}",
     *     operationId="getTableById",
     *     tags={"Tables"},
     *     summary="Get table by ID",
     *     description="Returns the details of a specific table.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Table ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Table details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Table retrieved successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Table")
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
        $table = $this->tableRepository->find($id);

        if (!$table) {
            return $this->sendError('Table not found.');
        }

        return $this->sendResponse(new TableResource($table), 'Table retrieved successfully.');
    }

    /**
     * @OA\Post(
     *     path="/dashboard/tables/create",
     *     operationId="createTable",
     *     tags={"Tables"},
     *     summary="Create a new table",
     *     description="Creates a new table with translations",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"section_id", "capacity"},
     *                 @OA\Property(property="capacity", type="integer", example=4),
     *                 @OA\Property(property="qr_code", type="string", example="qr123456"),
     *                 @OA\Property(property="status", type="boolean", example=true),
     *                 @OA\Property(property="section_id", type="integer", example=2),
     *                 @OA\Property(
     *                     property="translations[en][name]",
     *                     type="string",
     *                     example="Table 1"
     *                 ),
     *                 @OA\Property(
     *                     property="translations[ar][name]",
     *                     type="string",
     *                     example="طاولة 1"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Table created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Table")
     *     )
     * )
     */
    public function create(TableRequest $request)
    {
        $data = $request->all();

        $table = $this->tableRepository->create($data);

        return $this->sendResponse(new TableResource($table), 'Table created successfully.');
    }

    /**
     * @OA\Put(
     *     path="/dashboard/tables/update/{id}",
     *     operationId="updateTable",
     *     tags={"Tables"},
     *     summary="Update table",
     *     description="Updates table with translations",
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
     *                 @OA\Property(property="capacity", type="integer", example=4),
     *                 @OA\Property(property="qr_code", type="string", example="qr123456"),
     *                 @OA\Property(property="status", type="boolean", example=true),
     *                 @OA\Property(property="section_id", type="integer", example=2),
     *                 @OA\Property(
     *                     property="translations[en][name]",
     *                     type="string",
     *                     example="Updated Table"
     *                 ),
     *                 @OA\Property(
     *                     property="translations[ar][name]",
     *                     type="string",
     *                     example="طاولة محدثة"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Table updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Table")
     *     )
     * )
     */
    public function update(TableRequest $request, $id)
    {
        $data = $request->all();

        $table = $this->tableRepository->update($data, $id);

        return $this->sendResponse(new TableResource($table), 'Table updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/dashboard/tables/destroy/{id}",
     *     operationId="deleteTable",
     *     tags={"Tables"},
     *     summary="Delete table",
     *     description="Deletes a table by ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Table ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Table deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Table deleted successfully."),
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
        $table = $this->tableRepository->delete($id);

        return $this->sendResponse(new TableResource($table), 'Table deleted successfully.');
    }
}
