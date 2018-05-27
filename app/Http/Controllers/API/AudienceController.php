<?php

namespace App\Http\Controllers\API;

use App\Audience;
use App\Http\Resources\Audience as AudienceResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class AudienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OAS\Get(
     *   path="/api/audiences",
     *   summary="list audiences",
     *   tags={"audiences"},
     *   operationId="getBuildings",
     *   @OAS\Response(
     *     response=200,
     *     description="A list with audiences",
     *     @OAS\MediaType(
     *              mediaType="application/json",
     *              @OAS\Schema(
     *                  type="array",
     *                  @OAS\Items(
     *                      ref="#/components/schemas/Audience"
     *                  ),
     *              ),
     *          ),
     *     ),
     *   ),
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ip = $request->ip();
        Log::info('Called AudienceController@index from ' . $ip);
        return response(AudienceResource::collection(Audience::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OAS\Post(
     *     path="/api/audiences",
     *     tags={"audiences"},
     *     summary="Add audience",
     *     operationId="saveAudience",
     *     @OAS\Response(
     *         response=200,
     *         description="successful operation",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Audience"
     *             ),
     *         ),
     *     ),
     *     @OAS\RequestBody(
     *         description="add audience",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Audience"
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
            'name' => 'bail|required|unique:audiences|max:255',
            'building_id' => 'required|exists:buildings,id',
        ]);

        $audience = new Audience($request->toArray());
        $audience->save();
        return response(AudienceResource::make($audience));
    }

    /**
     * Display the specified resource.
     *
     * @OAS\Get(
     *     path="/api/audiences/{audienceId}",
     *     tags={"audiences"},
     *     description=">-
    For valid response try integer IDs with value >= 1 \ Other
    values will generated exceptions",
     *     operationId="getAudienceById",
     *     @OAS\Parameter(
     *         name="audienceId",
     *         in="path",
     *         description="ID of audience that needs to be fetched",
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
     *                 ref="#/components/schemas/Audience"
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
        return response(AudienceResource::make(Audience::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OAS\Put(
     *     path="/api/audiences/{audienceId}",
     *     tags={"audiences"},
     *     summary="Update an existing audience",
     *     operationId="updateAudience",
     *     @OAS\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OAS\Response(
     *         response=404,
     *         description="Audience not found"
     *     ),
     *     @OAS\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     @OAS\Parameter(
     *         name="audienceId",
     *         in="path",
     *         description="ID of audience to update",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OAS\RequestBody(
     *         description="add audience",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Audience"
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
        $request->validate([
            'name' => 'required|unique:audiences,name|max:255'
        ]);
        /** @var Audience $audience */
        $audience = Audience::find($id);
        $audience->update($request->toArray());
        return response(AudienceResource::make($audience));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OAS\Delete(
     *     path="/api/audiences/{audienceId}",
     *     tags={"audiences"},
     *     summary="Delete audience by ID",
     *     description=">-
    For valid response try integer IDs with positive integer value.\ \
    Negative or non-integer values will generate API errors",
     *     operationId="deleteAudience",
     *     @OAS\Parameter(
     *         name="audienceId",
     *         in="path",
     *         required=true,
     *         description="ID of the audience that needs to be deleted",
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
        return response(Audience::destroy($id));
    }
}
