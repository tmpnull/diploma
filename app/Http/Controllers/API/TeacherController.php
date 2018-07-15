<?php

namespace App\Http\Controllers\API;

use App\Teacher;
use App\Http\Resources\Teacher as TeacherResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Swagger\Annotations as OAS;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OAS\Get(
     *   path="/api/teachers",
     *   summary="list teachers",
     *   tags={"teachers"},
     *   operationId="getFaculties",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *   @OAS\Response(
     *     response=200,
     *     description="A list with teachers",
     *     @OAS\MediaType(
     *              mediaType="application/json",
     *              @OAS\Schema(
     *                  type="array",
     *                  @OAS\Items(
     *                      ref="#/components/schemas/Teacher"
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
        return response(TeacherResource::collection(Teacher::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OAS\Post(
     *     path="/api/teachers",
     *     tags={"teachers"},
     *     summary="Add teacher",
     *     operationId="saveTeacher",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *     @OAS\RequestBody(
     *         description="add teacher",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Teacher"
     *             ),
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=200,
     *         description="successful operation",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Teacher"
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
        $request->validate(['user_id' => 'bail|required|exists:users,id|unique:teachers', 'department_id' => 'required|exists:departments,id',]);

        $teacher = new Teacher($request->toArray());
        $teacher->save();
        return response(TeacherResource::make($teacher));
    }

    /**
     * Display the specified resource.
     *
     * @OAS\Get(
     *     path="/api/teachers/{teacherId}",
     *     tags={"teachers"},
     *     description=">-
    For valid response try integer IDs with value >= 1 \ Other
    values will generated exceptions",
     *     operationId="getTeacherById",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
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
     *     @OAS\Response(
     *         response=200,
     *         description="successful operation",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Teacher"
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
        return response(TeacherResource::make(Teacher::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OAS\Put(
     *     path="/api/teachers/{teacherId}",
     *     tags={"teachers"},
     *     summary="Update an existing teacher",
     *     operationId="updateTeacher",
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
     *         description="Teacher not found"
     *     ),
     *     @OAS\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     @OAS\Parameter(
     *         name="teacherId",
     *         in="path",
     *         description="ID of teacher to update",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OAS\RequestBody(
     *         description="add teacher",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Teacher"
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
        /** @var Teacher $teacher */
        $teacher = Teacher::find($id);
        $teacher->update($request->toArray());

        return response(TeacherResource::make($teacher));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OAS\Delete(
     *     path="/api/teachers/{teacherId}",
     *     tags={"teachers"},
     *     summary="Delete teacher by ID",
     *     description=">-
    For valid response try integer IDs with positive integer value.\ \
    Negative or non-integer values will generate API errors",
     *     operationId="deleteTeacher",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *     @OAS\Parameter(
     *         name="teacherId",
     *         in="path",
     *         required=true,
     *         description="ID of the teacher that needs to be deleted",
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
        return response(Teacher::destroy($id));
    }
}
