<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Requests\CurrencyRequest;
use App\Repositories\CurrencyRepository;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class CurrencyController extends BaseController
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(
        protected CurrencyRepository $currencyRepository
    ) {
        parent::__construct();
    }

    /**
     * @OA\Get(
     *     path="/dashboard/currencies/index",
     *     operationId="getCurrencies",
     *     tags={"Currencies"},
     *     summary="Get a list of currencies",
     *     description="Fetch a paginated list of currencies.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of currencies per page",
     *         required=false,
     *         @OA\Schema(type="integer", example=12)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Currencies retrieved successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Currencies retrieved successfully."),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Currency")),
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

        $currencies = $this->currencyRepository->paginate($limit);

        return $this->sendResponse($currencies, 'Currencies retrieved successfully.', true);
    }

    /**
     * @OA\Get(
     *     path="/dashboard/currencies/show/{id}",
     *     operationId="getCurrency",
     *     tags={"Currencies"},
     *     summary="Get a specific currency",
     *     description="Fetch details of a specific currency by its ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Currency ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Currency retrieved successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Currency retrieved successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Currency")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Category not found"),
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
    public function show($id)
    {
        $currency = $this->currencyRepository->find($id);

        if (is_null($currency)) {
            return $this->sendError('Currency not found.');
        }

        return $this->sendResponse($currency, 'Currency retrieved successfully.');
    }

    /**
     * @OA\Post(
     *     path="/dashboard/currencies/create",
     *     operationId="createCurrency",
     *     tags={"Currencies"},
     *     summary="Create a new currency",
     *     description="Create a new currency with the provided data.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Currency")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Currency created successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Currency created successfully."),
     *             @OA\Property(property="result", ref="#/components/schemas/Currency")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error"),
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
    public function create(CurrencyRequest $request)
    {
        $data = $request->all();

        $currency = $this->currencyRepository->create($data);

        return $this->sendResponse($currency, 'Currency created successfully.');
    }

    /**
     * @OA\Put(
     *     path="/dashboard/currencies/update/{id}",
     *     operationId="updateCurrency",
     *     tags={"Currencies"},
     *     summary="Update an existing currency",
     *     description="Update the details of a specific currency.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Currency ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Currency")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Currency updated successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Currency updated successfully."),
     *             @OA\Property(property="result", ref="#/components/schemas/Currency")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error"),
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
    public function update(CurrencyRequest $request, $id)
    {
        $data = $request->all();

        $currency = $this->currencyRepository->update($data, $id);

        return $this->sendResponse($currency, 'Currency updated successfully.');
    }

    /**
     * @OA\Delete(
     *     path="/dashboard/currencies/destroy/{id}",
     *     operationId="deleteCurrency",
     *     tags={"Currencies"},
     *     summary="Delete a currency",
     *     description="Delete a specific currency by its ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Currency ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Currency deleted successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Currency deleted successfully."),
     *             @OA\Property(property="result", type="object", example={})
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error"),
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
        $this->currencyRepository->delete($id);

        return $this->sendResponse([], 'Currency deleted successfully.');
    }
}
