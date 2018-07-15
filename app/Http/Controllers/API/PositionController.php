<?php

namespace App\Http\Controllers\API;

use App\Position;
use App\Http\Resources\Position as PositionResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Swagger\Annotations as OAS;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OAS\Get(
     *   path="/api/positions",
     *   summary="list positions",
     *   tags={"positions"},
     *   operationId="getFaculties",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *   @OAS\Response(
     *     response=200,
     *     description="A list with positions",
     *     @OAS\MediaType(
     *              mediaType="application/json",
     *              @OAS\Schema(
     *                  type="array",
     *                  @OAS\Items(
     *                      ref="#/components/schemas/Position"
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
        return response(PositionResource::collection(Position::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OAS\Post(
     *     path="/api/positions",
     *     tags={"positions"},
     *     summary="Add position",
     *     operationId="savePosition",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *     @OAS\RequestBody(
     *         description="add position",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Position"
     *             ),
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=200,
     *         description="successful operation",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Position"
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
        $request->validate(['name' => 'bail|required|unique:positions|max:255',]);

        $position = new Position($request->toArray());
        $position->save();
        return response(PositionResource::make($position));
    }

    /**
     * Display the specified resource.
     *
     * @OAS\Get(
     *     path="/api/positions/{positionId}",
     *     tags={"positions"},
     *     description=">-
    For valid response try integer IDs with value >= 1 \ Other
    values will generated exceptions",
     *     operationId="getPositionById",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *     @OAS\Parameter(
     *         name="positionId",
     *         in="path",
     *         description="ID of position that needs to be fetched",
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
     *                 ref="#/components/schemas/Position"
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
        return response(PositionResource::make(Position::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OAS\Put(
     *     path="/api/positions/{positionId}",
     *     tags={"positions"},
     *     summary="Update an existing position",
     *     operationId="updatePosition",
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
     *         description="Position not found"
     *     ),
     *     @OAS\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     @OAS\Parameter(
     *         name="positionId",
     *         in="path",
     *         description="ID of position to update",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OAS\RequestBody(
     *         description="add position",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Position"
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
        /** @var Position $position */
        $position = Position::find($id);
        $position->update($request->toArray());

        return response(PositionResource::make($position));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OAS\Delete(
     *     path="/api/positions/{positionId}",
     *     tags={"positions"},
     *     summary="Delete position by ID",
     *     description=">-
    For valid response try integer IDs with positive integer value.\ \
    Negative or non-integer values will generate API errors",
     *     operationId="deletePosition",
     *     security={
     *       {
     *         "bearer": {},
     *         "passport": {},
     *       },
     *     },
     *     @OAS\Parameter(
     *         name="positionId",
     *         in="path",
     *         required=true,
     *         description="ID of the position that needs to be deleted",
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
        return response(Position::destroy($id));
    }
}
