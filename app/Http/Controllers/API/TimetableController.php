<?php

namespace App\Http\Controllers\API;

use App\Services\TimetableService;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\QueryParameters\TimetableQueryParameters;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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
     * @return Response
     */
    public function index(): Response
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
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $request->validate(
            [
                'course_id' => 'bail|required|exists:courses,id|unique_with:timetables,day_of_week,number,is_numerator,
                group_id,audience_id',
                'day_of_week' => 'required',
                'number' => 'required',
                'is_numerator' => 'required',
                'is_first_semester' => 'required',
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
     * @return Response
     */
    public function show($id): Response
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
     *         name="dividend",
     *         in="query",
     *         description="Set period of time",
     *         @OAS\Schema(
     *             type="string",
     *             enum={"numerator","denominator","auto"}
     *         ),
     *     ),
     *     @OAS\Parameter(
     *         name="semester",
     *         in="query",
     *         description="Set semester",
     *         @OAS\Schema(
     *             type="string",
     *             enum={"first","second","auto"}
     *         ),
     *     ),
     *     @OAS\Parameter(
     *         name="day",
     *         in="query",
     *         description="Set filter for required date",
     *         @OAS\Schema(
     *             type="integer",
     *             enum={1,2,3,4,5}
     *         ),
     *     ),
     *     @OAS\Parameter(
     *         name="date",
     *         in="query",
     *         description="Set filter for required date YYYY-MM-DD",
     *         @OAS\Schema(
     *             type="date",
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
     * @return Response
     */
    public function showByGroupId(Request $request, int $id): Response
    {
        $validator = Validator::make($request->all(), [
            'dividend' => 'in:numerator,denominator,auto',
            'semester' => 'in:first,second,auto',
            'date' => 'bail|date_format:Y-m-d|required_if:semester,auto|required_if:date,auto',
            'day' => 'integer|min:1|max:5',
            'id' => 'exists:groups,id'
        ]);
        if ($validator->fails()) {
            return response($validator->errors()->all(), 403);
        }
        $queryParams = new TimetableQueryParameters($request);

        return response($this->timetableService->showByGroupId($id, $queryParams));
    }

    /**
     * Display the specified resource.
     *
     * @OAS\Get(
     *     path="/api/timetables/teacher/{teacherId}",
     *     tags={"timetables"},
     *     description=">-
    For valid response try integer IDs with value >= 1 \ Other
    values will generated exceptions",
     *     operationId="getTimetableByTeacherId",
     *     @OAS\Parameter(
     *         name="teacherId",
     *         in="path",
     *         description="ID of teacher that needs to be fetched",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64",
     *             minimum=1,
     *         ),
     *     ),
     *     @OAS\Parameter(
     *         name="dividend",
     *         in="query",
     *         description="Set period of time",
     *         @OAS\Schema(
     *             type="string",
     *             enum={"numerator","denominator","auto"}
     *         ),
     *     ),
     *     @OAS\Parameter(
     *         name="semester",
     *         in="query",
     *         description="Set semester",
     *         @OAS\Schema(
     *             type="string",
     *             enum={"first","second","auto"}
     *         ),
     *     ),
     *     @OAS\Parameter(
     *         name="day",
     *         in="query",
     *         description="Set filter for required date",
     *         @OAS\Schema(
     *             type="integer",
     *             enum={1,2,3,4,5}
     *         ),
     *     ),
     *     @OAS\Parameter(
     *         name="date",
     *         in="query",
     *         description="Set filter for required date YYYY-MM-DD",
     *         @OAS\Schema(
     *             type="date",
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
     * @return Response
     */
    public function showByTeacherId(Request $request, int $id): Response
    {
        $validator = Validator::make($request->all(), [
            'dividend' => 'bail|in:numerator,denominator,auto',
            'date' => 'required_if:dividend,auto|date_format:Y-m-d',
            'day' => 'day|integer|min:1|max:5',
            'id' => 'exists:teachers,id'
        ]);
        if ($validator->fails()) {
            return response($validator->errors()->all(), 403);
        }
        $queryParams = new TimetableQueryParameters($request);

        return response($this->timetableService->showByTeacherId($id, $queryParams));
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
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id): Response
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
     * @return Response
     */
    public function destroy($id)
    {
        return response($this->timetableService->destroy($id));
    }
}
