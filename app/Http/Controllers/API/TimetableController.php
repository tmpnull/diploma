<?php

namespace App\Http\Controllers\API;

use App\Services\TimetableService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\QueryParameters\TimetableQueryParameters;

class TimetableController extends Controller
{
    private $timetableService;

    /**
     * Create a new controller instance.
     *
     * @param TimetableService $timetableService
     */
    public function __construct(TimetableService $timetableService)
    {
        $this->timetableService = $timetableService;
    }

    /**
     * Display a listing of the resource.
     *
     * @OAS\Get(
     *   path="/api/timetables",
     *   summary="list timetables",
     *   tags={"timetables"},
     *   operationId="getTimetables",
     *   @OAS\Response(
     *     response=200,
     *     description="A list with timetables",
     *     @OAS\MediaType(
     *              mediaType="application/json",
     *              @OAS\Schema(
     *                  type="array",
     *                  @OAS\Items(
     *                      ref="#/components/schemas/Timetable"
     *                  ),
     *              ),
     *          ),
     *     ),
     *   ),
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response($this->timetableService->index());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OAS\Post(
     *     path="/api/timetables",
     *     tags={"timetables"},
     *     summary="Add new course to the timetable",
     *     operationId="saveTimetable",
     *     @OAS\Response(
     *         response=200,
     *         description="successful operation",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Timetable"
     *             ),
     *         ),
     *     ),
     *     @OAS\RequestBody(
     *         description="add user",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Timetable"
     *             ),
     *         ),
     *     ),
     * )
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'course_id' => 'bail|required|exists:courses,id|unique_with:timetables,day_of_week,number,is_numerator,
                group_id,audience_id',
                'day_of_week' => 'required',
                'number' => 'required',
                'is_numerator' => 'required',
                'group_id' => 'required|exists:groups,id',
                'audience_id' => 'required|exists:audiences,id',
            ]
        );

        return response($this->timetableService->store($request->toArray()));
    }

    /**
     * Display the specified resource.
     *
     * @OAS\Get(
     *     path="/api/timetables/{userId}",
     *     tags={"timetables"},
     *     description=">-
    For valid response try integer IDs with value >= 1 \ Other
    values will generated exceptions",
     *     operationId="getTimetableById",
     *     @OAS\Parameter(
     *         name="userId",
     *         in="path",
     *         description="ID of timetable that needs to be fetched",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64",
     *             minimum=1,
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=200,
     *         description="successful operation",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Timetable"
     *             ),
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OAS\Response(
     *         response=404,
     *         description="Order not found"
     *     ),
     * )
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response($this->timetableService->show($id));
    }

    /**
     * Display the specified resource.
     *
     * @OAS\Get(
     *     path="/api/timetables/group/{groupId}",
     *     tags={"timetables"},
     *     description=">-
    For valid response try integer IDs with value >= 1 \ Other
    values will generated exceptions",
     *     operationId="getTimetableByGroupId",
     *     @OAS\Parameter(
     *         name="groupId",
     *         in="path",
     *         description="ID of group that needs to be fetched",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64",
     *             minimum=1,
     *         ),
     *     ),
     *     @OAS\Parameter(
     *         name="filterBy",
     *         in="query",
     *         description="ID of pet that needs to be fetched",
     *         @OAS\Schema(
     *             type="string",
     *         ),
     *     ),
     *     @OAS\Parameter(
     *         name="filterByPeriod",
     *         in="query",
     *         description="Set period of time",
     *         @OAS\Schema(
     *             type="string",
     *         ),
     *     ),
     *     @OAS\Parameter(
     *         name="filterByDate",
     *         in="query",
     *         description="Set filter for required date",
     *         @OAS\Schema(
     *             type="string",
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=200,
     *         description="successful operation",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Timetable"
     *             ),
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OAS\Response(
     *         response=404,
     *         description="Order not found"
     *     ),
     * )
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showByGroupId(Request $request, int $id)
    {
        $request->validate(
            [
                'period' => 'bail|in:day,week',
                'dividend' => 'in:numerator,denominator',
                'date' => 'required_with:period|date_format:Y-m-d',
                'id' => 'exists:groups,id'
            ]
        );
        $queryParams = new TimetableQueryParameters($request);

        return response($this->timetableService->showByGroupId($id, $queryParams));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OAS\Put(
     *     path="/api/timetables/{userId}",
     *     tags={"timetables"},
     *     summary="Update an existing user",
     *     operationId="updateTimetable",
     *     @OAS\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OAS\Response(
     *         response=404,
     *         description="Timetable not found"
     *     ),
     *     @OAS\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     @OAS\Parameter(
     *         name="userId",
     *         in="path",
     *         description="ID of user to update",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OAS\RequestBody(
     *         description="add user",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Timetable"
     *             ),
     *         ),
     *     ),
     * )
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->toArray();

        return response($this->timetableService->update($id, $data));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OAS\Delete(
     *     path="/api/timetables/{userId}",
     *     tags={"timetables"},
     *     summary="Delete user by ID",
     *     description=">-
    For valid response try integer IDs with positive integer value.\ \
    Negative or non-integer values will generate API errors",
     *     operationId="deleteTimetable",
     *     @OAS\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID of the user that needs to be deleted",
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64",
     *             minimum=1
     *         )
     *     ),
     *     @OAS\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OAS\Response(
     *         response=404,
     *         description="Order not found"
     *     )
     * ),
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response($this->timetableService->destroy($id));
    }
}
