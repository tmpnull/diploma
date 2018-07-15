<?php

namespace App\Http\Controllers\API;

use App\Faculty;
use App\Http\Resources\Faculty as FacultyResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Swagger\Annotations as OAS;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OAS\Get(
     *   path="/api/faculties",
     *   summary="list faculties",
     *   tags={"faculties"},
     *   operationId="getFaculties",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *   @OAS\Response(
     *     response=200,
     *     description="A list with faculties",
     *     @OAS\MediaType(
     *              mediaType="application/json",
     *              @OAS\Schema(
     *                  type="array",
     *                  @OAS\Items(
     *                      ref="#/components/schemas/Faculty"
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
        return response(FacultyResource::collection(Faculty::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OAS\Post(
     *     path="/api/faculties",
     *     tags={"faculties"},
     *     summary="Add faculty",
     *     operationId="saveFaculty",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *     @OAS\RequestBody(
     *         description="add faculty",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Faculty"
     *             ),
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=200,
     *         description="successful operation",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Faculty"
     *             ),
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=422,
     *         description="wrong data passed",
     *     ),
     * )
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'bail|required|unique:faculties|max:255', 'number' => 'required|unique:faculties', 'abbreviation' => 'required|unique:faculties',]);

        $faculty = new Faculty($request->toArray());
        $faculty->save();
        return response(FacultyResource::make($faculty));
    }

    /**
     * Display the specified resource.
     *
     * @OAS\Get(
     *     path="/api/faculties/{facultyId}",
     *     tags={"faculties"},
     *     description=">-
    For valid response try integer IDs with value >= 1 \ Other
    values will generated exceptions",
     *     operationId="getFacultyById",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *     @OAS\Parameter(
     *         name="facultyId",
     *         in="path",
     *         description="ID of faculty that needs to be fetched",
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
     *                 ref="#/components/schemas/Faculty"
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
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response(FacultyResource::make(Faculty::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OAS\Put(
     *     path="/api/faculties/{facultyId}",
     *     tags={"faculties"},
     *     summary="Update an existing faculty",
     *     operationId="updateFaculty",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *     @OAS\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OAS\Response(
     *         response=404,
     *         description="Faculty not found"
     *     ),
     *     @OAS\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     @OAS\Parameter(
     *         name="facultyId",
     *         in="path",
     *         description="ID of faculty to update",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OAS\RequestBody(
     *         description="add faculty",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Faculty"
     *             ),
     *         ),
     *     ),
     * )
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /** @var Faculty $faculty */
        $faculty = Faculty::find($id);
        $faculty->update($request->toArray());

        return response(FacultyResource::make($faculty));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OAS\Delete(
     *     path="/api/faculties/{facultyId}",
     *     tags={"faculties"},
     *     summary="Delete faculty by ID",
     *     description=">-
    For valid response try integer IDs with positive integer value.\ \
    Negative or non-integer values will generate API errors",
     *     operationId="deleteFaculty",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *     @OAS\Parameter(
     *         name="facultyId",
     *         in="path",
     *         required=true,
     *         description="ID of the faculty that needs to be deleted",
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
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response(Faculty::destroy($id));
    }
}
