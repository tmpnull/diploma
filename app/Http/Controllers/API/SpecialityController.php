<?php

namespace App\Http\Controllers\API;

use App\Speciality;
use App\Http\Resources\Speciality as SpecialityResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OAS\Get(
     *   path="/api/specialities",
     *   summary="list specialities",
     *   tags={"specialities"},
     *   operationId="getSpecialities",
     *   @OAS\Response(
     *     response=200,
     *     description="A list with specialities",
     *     @OAS\MediaType(
     *              mediaType="application/json",
     *              @OAS\Schema(
     *                  type="array",
     *                  @OAS\Items(
     *                      ref="#/components/schemas/Speciality"
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
        return response(SpecialityResource::collection(Speciality::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OAS\Post(
     *     path="/api/specialities",
     *     tags={"specialities"},
     *     summary="Add speciality",
     *     operationId="saveSpeciality",
     *     @OAS\Response(
     *         response=200,
     *         description="successful operation",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Speciality"
     *             ),
     *         ),
     *     ),
     *     @OAS\RequestBody(
     *         description="add speciality",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Speciality"
     *             ),
     *         ),
     *     ),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|unique:specialities|max:255',
            'number' => 'required|unique:specialities',
            'department_id' => 'required|exists:departments,id',
        ]);

        $speciality = new Speciality($request->toArray());
        $speciality->save();
        return response(SpecialityResource::make($speciality));
    }

    /**
     * Display the specified resource.
     *
     * @OAS\Get(
     *     path="/api/specialities/{specialityId}",
     *     tags={"specialities"},
     *     description=">-
    For valid response try integer IDs with value >= 1 \ Other
    values will generated exceptions",
     *     operationId="getSpecialityById",
     *     @OAS\Parameter(
     *         name="specialityId",
     *         in="path",
     *         description="ID of speciality that needs to be fetched",
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
     *                 ref="#/components/schemas/Speciality"
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
        return response(SpecialityResource::make(Speciality::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OAS\Put(
     *     path="/api/specialities/{specialityId}",
     *     tags={"specialities"},
     *     summary="Update an existing speciality",
     *     operationId="updateSpeciality",
     *     @OAS\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OAS\Response(
     *         response=404,
     *         description="Speciality not found"
     *     ),
     *     @OAS\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     @OAS\Parameter(
     *         name="specialityId",
     *         in="path",
     *         description="ID of speciality to update",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OAS\RequestBody(
     *         description="add speciality",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Speciality"
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
        /** @var Speciality $speciality */
        $speciality = Speciality::find($id);
        $speciality->update($request->toArray());
        return response(SpecialityResource::make($speciality));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OAS\Delete(
     *     path="/api/specialities/{specialityId}",
     *     tags={"specialities"},
     *     summary="Delete speciality by ID",
     *     description=">-
    For valid response try integer IDs with positive integer value.\ \
    Negative or non-integer values will generate API errors",
     *     operationId="deleteSpeciality",
     *     @OAS\Parameter(
     *         name="specialityId",
     *         in="path",
     *         required=true,
     *         description="ID of the speciality that needs to be deleted",
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
        return response(Speciality::destroy($id));
    }
}
