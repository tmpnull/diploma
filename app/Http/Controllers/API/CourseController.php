<?php

namespace App\Http\Controllers\API;

use App\Course;
use App\Http\Resources\Course as CourseResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OAS\Get(
     *   path="/api/courses",
     *   summary="list courses",
     *   tags={"courses"},
     *   operationId="getFaculties",
     *   @OAS\Response(
     *     response=200,
     *     description="A list with courses",
     *     @OAS\MediaType(
     *              mediaType="application/json",
     *              @OAS\Schema(
     *                  type="array",
     *                  @OAS\Items(
     *                      ref="#/components/schemas/Course"
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
        return response(CourseResource::collection(Course::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OAS\Post(
     *     path="/api/courses",
     *     tags={"courses"},
     *     summary="Add course",
     *     operationId="saveCourse",
     *     @OAS\RequestBody(
     *         description="add course",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Course"
     *             ),
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=200,
     *         description="successful operation",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Course"
     *             ),
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=422,
     *         description="wrong data passed",
     *     ),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|unique:courses|max:255',
        ]);

        $course = new Course($request->toArray());
        $course->save();
        return response(CourseResource::make($course));
    }

    /**
     * Display the specified resource.
     *
     * @OAS\Get(
     *     path="/api/courses/{courseId}",
     *     tags={"courses"},
     *     description=">-
    For valid response try integer IDs with value >= 1 \ Other
    values will generated exceptions",
     *     operationId="getCourseById",
     *     @OAS\Parameter(
     *         name="courseId",
     *         in="path",
     *         description="ID of course that needs to be fetched",
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
     *                 ref="#/components/schemas/Course"
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response(CourseResource::make(Course::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OAS\Put(
     *     path="/api/courses/{courseId}",
     *     tags={"courses"},
     *     summary="Update an existing course",
     *     operationId="updateCourse",
     *     @OAS\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OAS\Response(
     *         response=404,
     *         description="Course not found"
     *     ),
     *     @OAS\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     @OAS\Parameter(
     *         name="courseId",
     *         in="path",
     *         description="ID of course to update",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OAS\RequestBody(
     *         description="add course",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Course"
     *             ),
     *         ),
     *     ),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /** @var Course $course */
        $course = Course::find($id);
        $course->update($request->toArray());

        return response(CourseResource::make($course));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OAS\Delete(
     *     path="/api/courses/{courseId}",
     *     tags={"courses"},
     *     summary="Delete course by ID",
     *     description=">-
    For valid response try integer IDs with positive integer value.\ \
    Negative or non-integer values will generate API errors",
     *     operationId="deleteCourse",
     *     @OAS\Parameter(
     *         name="courseId",
     *         in="path",
     *         required=true,
     *         description="ID of the course that needs to be deleted",
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response(Course::destroy($id));
    }
}
