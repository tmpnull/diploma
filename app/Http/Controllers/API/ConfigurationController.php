<?php

namespace App\Http\Controllers\API;

use App\Configuration;
use App\Http\Resources\Configuration as ConfigurationResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OAS\Get(
     *   path="/api/configurations",
     *   summary="list configurations",
     *   tags={"configurations"},
     *   operationId="getFaculties",
     *   @OAS\Response(
     *     response=200,
     *     description="A list with configurations",
     *     @OAS\MediaType(
     *              mediaType="application/json",
     *              @OAS\Schema(
     *                  type="array",
     *                  @OAS\Items(
     *                      ref="#/components/schemas/Configuration"
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
        return response(ConfigurationResource::collection(Configuration::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OAS\Post(
     *     path="/api/configurations",
     *     tags={"configurations"},
     *     summary="Add configuration",
     *     operationId="saveConfiguration",
     *     @OAS\RequestBody(
     *         description="add configuration",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Configuration"
     *             ),
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=200,
     *         description="successful operation",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Configuration"
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
            'key' => 'bail|required|unique:configurations|max:255',
        ]);

        $configuration = new Configuration($request->toArray());
        $configuration->save();
        return response(ConfigurationResource::make($configuration));
    }

    /**
     * Display the specified resource.
     *
     * @OAS\Get(
     *     path="/api/configurations/{configurationId}",
     *     tags={"configurations"},
     *     description=">-
    For valid response try integer IDs with value >= 1 \ Other
    values will generated exceptions",
     *     operationId="getConfigurationById",
     *     @OAS\Parameter(
     *         name="configurationId",
     *         in="path",
     *         description="ID of configuration that needs to be fetched",
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
     *                 ref="#/components/schemas/Configuration"
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
        return response(ConfigurationResource::make(Configuration::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OAS\Put(
     *     path="/api/configurations/{configurationId}",
     *     tags={"configurations"},
     *     summary="Update an existing configuration",
     *     operationId="updateConfiguration",
     *     @OAS\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OAS\Response(
     *         response=404,
     *         description="Configuration not found"
     *     ),
     *     @OAS\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     @OAS\Parameter(
     *         name="configurationId",
     *         in="path",
     *         description="ID of configuration to update",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OAS\RequestBody(
     *         description="add configuration",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Configuration"
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
        /** @var Configuration $configuration */
        $configuration = Configuration::find($id);
        $configuration->update($request->toArray());

        return response(ConfigurationResource::make($configuration));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OAS\Delete(
     *     path="/api/configurations/{configurationId}",
     *     tags={"configurations"},
     *     summary="Delete configuration by ID",
     *     description=">-
    For valid response try integer IDs with positive integer value.\ \
    Negative or non-integer values will generate API errors",
     *     operationId="deleteConfiguration",
     *     @OAS\Parameter(
     *         name="configurationId",
     *         in="path",
     *         required=true,
     *         description="ID of the configuration that needs to be deleted",
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
        return response(Configuration::destroy($id));
    }
}
