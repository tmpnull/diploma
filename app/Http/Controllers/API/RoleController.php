<?php

namespace App\Http\Controllers\API;

use App\Role;
use App\Http\Resources\Role as RoleResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OAS\Get(
     *   path="/api/roles",
     *   summary="list roles",
     *   tags={"roles"},
     *   operationId="getFaculties",
     *   @OAS\Response(
     *     response=200,
     *     description="A list with roles",
     *     @OAS\MediaType(
     *              mediaType="application/json",
     *              @OAS\Schema(
     *                  type="array",
     *                  @OAS\Items(
     *                      ref="#/components/schemas/Role"
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
        return response(RoleResource::collection(Role::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OAS\Post(
     *     path="/api/roles",
     *     tags={"roles"},
     *     summary="Add role",
     *     operationId="saveRole",
     *     @OAS\RequestBody(
     *         description="add role",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Role"
     *             ),
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=200,
     *         description="successful operation",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Role"
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
            'name' => 'bail|required|unique:roles|max:255',
        ]);

        $role = new Role($request->toArray());
        $role->save();
        return response(RoleResource::make($role));
    }

    /**
     * Display the specified resource.
     *
     * @OAS\Get(
     *     path="/api/roles/{roleId}",
     *     tags={"roles"},
     *     description=">-
    For valid response try integer IDs with value >= 1 \ Other
    values will generated exceptions",
     *     operationId="getRoleById",
     *     @OAS\Parameter(
     *         name="roleId",
     *         in="path",
     *         description="ID of role that needs to be fetched",
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
     *                 ref="#/components/schemas/Role"
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
        return response(RoleResource::make(Role::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OAS\Put(
     *     path="/api/roles/{roleId}",
     *     tags={"roles"},
     *     summary="Update an existing role",
     *     operationId="updateRole",
     *     @OAS\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OAS\Response(
     *         response=404,
     *         description="Role not found"
     *     ),
     *     @OAS\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     @OAS\Parameter(
     *         name="roleId",
     *         in="path",
     *         description="ID of role to update",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OAS\RequestBody(
     *         description="add role",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/Role"
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
        /** @var Role $role */
        $role = Role::find($id);
        $role->update($request->toArray());

        return response(RoleResource::make($role));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OAS\Delete(
     *     path="/api/roles/{roleId}",
     *     tags={"roles"},
     *     summary="Delete role by ID",
     *     description=">-
    For valid response try integer IDs with positive integer value.\ \
    Negative or non-integer values will generate API errors",
     *     operationId="deleteRole",
     *     @OAS\Parameter(
     *         name="roleId",
     *         in="path",
     *         required=true,
     *         description="ID of the role that needs to be deleted",
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
        return response(Role::destroy($id));
    }
}
