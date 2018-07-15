<?php

namespace App\Http\Controllers\API;

use App\Student;
use App\Http\Resources\Student as StudentResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Swagger\Annotations as OAS;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OAS\Get(
     *   path="/api/students",
     *   summary="list students",
     *   tags={"students"},
     *   operationId="getFaculties",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *   @OAS\Response(
     *     response=200,
     *     description="A list with students",
     *     @OAS\MediaType(
     *              mediaType="application/json",
     *              @OAS\Schema(
     *                  type="array",
     *                  @OAS\Items(
     *                      ref="#/components/schemas/Student"
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
        return response(StudentResource::collection(Student::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OAS\Post(
     *     path="/api/students",
     *     tags={"students"},
     *     summary="Add student",
     *     operationId="saveStudent",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *     @OAS\RequestBody(
     *         description="add student",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Student"
     *             ),
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=200,
     *         description="successful operation",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Student"
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
        $request->validate(['user_id' => 'bail|required|exists:users,id|unique:students', 'group_id' => 'required|exists:groups,id',]);

        $student = new Student($request->toArray());
        $student->save();
        return response(StudentResource::make($student));
    }

    /**
     * Display the specified resource.
     *
     * @OAS\Get(
     *     path="/api/students/{studentId}",
     *     tags={"students"},
     *     description=">-
    For valid response try integer IDs with value >= 1 \ Other
    values will generated exceptions",
     *     operationId="getStudentById",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *     @OAS\Parameter(
     *         name="studentId",
     *         in="path",
     *         description="ID of student that needs to be fetched",
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
     *                 ref="#/components/schemas/Student"
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
        return response(StudentResource::make(Student::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OAS\Put(
     *     path="/api/students/{studentId}",
     *     tags={"students"},
     *     summary="Update an existing student",
     *     operationId="updateStudent",
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
     *         description="Student not found"
     *     ),
     *     @OAS\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     @OAS\Parameter(
     *         name="studentId",
     *         in="path",
     *         description="ID of student to update",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OAS\RequestBody(
     *         description="add student",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Student"
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
        /** @var Student $student */
        $student = Student::find($id);
        $student->update($request->toArray());

        return response(StudentResource::make($student));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OAS\Delete(
     *     path="/api/students/{studentId}",
     *     tags={"students"},
     *     summary="Delete student by ID",
     *     description=">-
    For valid response try integer IDs with positive integer value.\ \
    Negative or non-integer values will generate API errors",
     *     operationId="deleteStudent",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *     @OAS\Parameter(
     *         name="studentId",
     *         in="path",
     *         required=true,
     *         description="ID of the student that needs to be deleted",
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
        return response(Student::destroy($id));
    }
}
