<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Repositories\CurrencyExchangeRateRepository;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class CurrencyExchangeRateController extends BaseController
{

      /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(
        protected CurrencyExchangeRateRepository $currencyExchangeRateRepository
    ) {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/dashboard/currency-exchange-rates/index",
     *     operationId="getCurrencyExchangeRates",
     *     tags={"CurrencyExchangeRates"},
     *     summary="Get list of currency exchange rates",
     *     description="Returns a list of currency exchange rates with pagination.",
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
     *         description="List of currency exchange rates",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Currency Exchanges Rate retrieved successfully."),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/CurrencyExchangeRate")),
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

        $currencyExchangeRates = $this->currencyExchangeRateRepository->paginate($limit);

        return $this->sendResponse($currencyExchangeRates, 'Currency Exchange Rates retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/dashboard/currency-exchange-rates/show/{id}",
     *     operationId="getCurrencyExchangeRateById",
     *     tags={"CurrencyExchangeRates"},
     *     summary="Get currency exchange rate by ID",
     *     description="Returns the details of a specific currency exchange rate.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Currency Exchange Rate ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Currency Exchange Rate details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Currency Exchange Rate retrieved successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/CurrencyExchangeRate")
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
        $currencyExchangeRate = $this->currencyExchangeRateRepository->find($id);

        if (is_null($currencyExchangeRate)) {
            return $this->sendError('Currency Exchange Rate not found.');
        }

        return $this->sendResponse($currencyExchangeRate, 'Currency Exchange Rate retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/dashboard/currency-exchange-rates/create",
     *     operationId="createCurrencyExchangeRate",
     *     tags={"CurrencyExchangeRates"},
     *     summary="Create a new currency exchange rate",
     *     description="Creates a new currency exchange rate.",
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
     *         description="Currency Exchange Rate created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Currency Exchange created successfully."),
     *             @OA\Property(property="result", ref="#/components/schemas/CurrencyExchangeRate")
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
            'currency_id' => 'required',
            'exchange_rate' => 'required',
            'date' => 'required',
        ]);

        $currencyExchangeRate = $this->currencyExchangeRateRepository->create($data);

        return $this->sendResponse($currencyExchangeRate, 'Currency Exchange Rate created successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/dashboard/currency-exchange-rates/update/{id}",
     *     operationId="updateCurrencyExchangeRate",
     *     tags={"CurrencyExchangeRates"},
     *     summary="Update currency exchange rate",
     *     description="Updates the currency exchange rate with given data.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Currency Exchange Rate ID",
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
     *         description="Currency Exchange Rate updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Currency Exchange Rate updated successfully."),
     *             @OA\Property(property="result", ref="#/components/schemas/CurrencyExchangeRate")
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
            'currency_id' => 'required',
            'exchange_rate' => 'required',
            'date' => 'required',
        ]);

        $currencyExchangeRate = $this->currencyExchangeRateRepository->update($data, $id);

        return $this->sendResponse($currencyExchangeRate, 'Currency Exchange Rate updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/dashboard/currency-exchange-rates/destroy/{id}",
     *     operationId="deleteCurrencyExchangeRate",
     *     tags={"CurrencyExchangeRates"},
     *     summary="Delete currency exchange rate",
     *     description="Deletes a currency exchange rate by ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Currency Exchange Rate ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Currency Exchange Rate deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Currency Exchange Rate deleted successfully."),
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
        $currencyExchangeRate = $this->currencyExchangeRateRepository->find($id);

        if (is_null($currencyExchangeRate)) {
            return $this->sendError('Currency Exchange Rate not found.');
        }

        $this->currencyExchangeRateRepository->delete($id);

        return $this->sendResponse([], 'Currency Exchange Rate deleted successfully.');
    }
}
