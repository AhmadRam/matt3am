<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Requests\SectionRequest;
use App\Http\Resources\SectionResource;
use App\Repositories\SectionRepository;
use Illuminate\Http\Request;

class SectionController extends BaseController
{

    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(
        protected SectionRepository $sectionRepository
    ) {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/dashboard/sections/index",
     *     operationId="getSections",
     *     tags={"Sections"},
     *     summary="Get list of sections",
     *     description="Returns a list of sections with pagination.",
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
     *         description="List of sections",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Sections retrieved successfully."),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Section")),
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

        $sections = $this->sectionRepository->paginate($limit);

        return $this->sendResponse((SectionResource::class)::collection($sections), 'Sections retrieved successfully.', true);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/dashboard/sections/show/{id}",
     *     operationId="getSectionById",
     *     tags={"Sections"},
     *     summary="Get customer by ID",
     *     description="Returns the details of a specific customer.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Section ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Section details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Section retrieved successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Section")
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
        $section = $this->sectionRepository->find($id);

        if (empty($section)) {
            return $this->sendError('Section not found.');
        }

        return $this->sendResponse(new SectionResource($section), 'Section retrieved successfully.');
    }

    /**
     * @OA\Post(
     *     path="/dashboard/sections/create",
     *     operationId="createSection",
     *     tags={"Sections"},
     *     summary="Create a new section",
     *     description="Creates a new section with translations",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                     @OA\Schema(ref="#/components/schemas/Section"),
     *                     @OA\Schema(
     *                         required={"restaurant_id"},
     *                         @OA\Property(
     *                             property="restaurant_id",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                         @OA\Property(
     *                             property="translations[en][name]",
     *                             type="string",
     *                             example="Main Section"
     *                         ),
     *                         @OA\Property(
     *                             property="translations[ar][name]",
     *                             type="string",
     *                             example="القسم الرئيسي"
     *                         )
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Section created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Section")
     *     )
     * )
     */
    public function create(SectionRequest $request)
    {
        $data = $request->all();

        $section = $this->sectionRepository->create($data);

        return $this->sendResponse(new SectionResource($section), 'Section created successfully.');
    }

    /**
     * @OA\Put(
     *     path="/dashboard/sections/update/{id}",
     *     operationId="updateSection",
     *     tags={"Sections"},
     *     summary="Update section",
     *     description="Updates section with translations",
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
     *                     @OA\Schema(ref="#/components/schemas/Section"),
     *                     @OA\Schema(
     *                         @OA\Property(
     *                             property="restaurant_id",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                         @OA\Property(
     *                             property="translations[en][name]",
     *                             type="string",
     *                             example="Updated Section"
     *                         ),
     *                         @OA\Property(
     *                             property="translations[ar][name]",
     *                             type="string",
     *                             example="قسم محدث"
     *                         )
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Section updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Section")
     *     )
     * )
     */
    public function update(SectionRequest $request, $id)
    {
        $data = $request->all();

        $section = $this->sectionRepository->update($data, $id);

        return $this->sendResponse(new SectionResource($section), 'Section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/dashboard/sections/destroy/{id}",
     *     operationId="deleteSection",
     *     tags={"Sections"},
     *     summary="Delete section",
     *     description="Deletes a section by ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Section ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Section deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Section deleted successfully."),
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
        $section = $this->sectionRepository->delete($id);

        return $this->sendResponse(new SectionResource($section), 'Section deleted successfully.');
    }
}
