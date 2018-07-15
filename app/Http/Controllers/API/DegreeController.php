<?php

namespace App\Http\Controllers\API;

use App\Degree;
use App\Http\Resources\Degree as DegreeResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Swagger\Annotations as OAS;

class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OAS\Get(
     *   path="/api/degrees",
     *   summary="list degrees",
     *   tags={"degrees"},
     *   operationId="getFaculties",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *   @OAS\Response(
     *     response=200,
     *     description="A list with degrees",
     *     @OAS\MediaType(
     *              mediaType="application/json",
     *              @OAS\Schema(
     *                  type="array",
     *                  @OAS\Items(
     *                      ref="#/components/schemas/Degree"
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
        return response(DegreeResource::collection(Degree::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OAS\Post(
     *     path="/api/degrees",
     *     tags={"degrees"},
     *     summary="Add degree",
     *     operationId="saveDegree",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *     @OAS\RequestBody(
     *         description="add degree",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Degree"
     *             ),
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=200,
     *         description="successful operation",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Degree"
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
        $request->validate(['name' => 'bail|required|unique:degrees|max:255',]);

        $degree = new Degree($request->toArray());
        $degree->save();
        return response(DegreeResource::make($degree));
    }

    /**
     * Display the specified resource.
     *
     * @OAS\Get(
     *     path="/api/degrees/{degreeId}",
     *     tags={"degrees"},
     *     description=">-
    For valid response try integer IDs with value >= 1 \ Other
    values will generated exceptions",
     *     operationId="getDegreeById",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *     @OAS\Parameter(
     *         name="degreeId",
     *         in="path",
     *         description="ID of degree that needs to be fetched",
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
     *                 ref="#/components/schemas/Degree"
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
        return response(DegreeResource::make(Degree::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OAS\Put(
     *     path="/api/degrees/{degreeId}",
     *     tags={"degrees"},
     *     summary="Update an existing degree",
     *     operationId="updateDegree",
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
     *         description="Degree not found"
     *     ),
     *     @OAS\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     @OAS\Parameter(
     *         name="degreeId",
     *         in="path",
     *         description="ID of degree to update",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OAS\RequestBody(
     *         description="add degree",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Degree"
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
        /** @var Degree $degree */
        $degree = Degree::find($id);
        $degree->update($request->toArray());

        return response(DegreeResource::make($degree));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OAS\Delete(
     *     path="/api/degrees/{degreeId}",
     *     tags={"degrees"},
     *     summary="Delete degree by ID",
     *     description=">-
    For valid response try integer IDs with positive integer value.\ \
    Negative or non-integer values will generate API errors",
     *     operationId="deleteDegree",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *     @OAS\Parameter(
     *         name="degreeId",
     *         in="path",
     *         required=true,
     *         description="ID of the degree that needs to be deleted",
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
        return response(Degree::destroy($id));
    }
}
