<?php

namespace App\Http\Controllers\API;

use App\File;
use App\Http\Resources\File as FileResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OAS\Get(
     *   path="/api/files",
     *   summary="list files",
     *   tags={"files"},
     *   operationId="getFaculties",
     *   @OAS\Response(
     *     response=200,
     *     description="A list with files",
     *     @OAS\MediaType(
     *              mediaType="application/json",
     *              @OAS\Schema(
     *                  type="array",
     *                  @OAS\Items(
     *                      ref="#/components/schemas/File"
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
        return response(FileResource::collection(File::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OAS\Post(
     *     path="/api/files",
     *     tags={"files"},
     *     summary="Add file",
     *     operationId="saveFile",
     *     @OAS\RequestBody(
     *         description="add file",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/File"
     *             ),
     *         ),
     *     ),
     *     @OAS\Response(
     *         response=200,
     *         description="successful operation",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/File"
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
            'name' => 'bail|required|unique:files|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $file = new File($request->toArray());
        $file->save();
        return response(FileResource::make($file));
    }

    /**
     * Display the specified resource.
     *
     * @OAS\Get(
     *     path="/api/files/{fileId}",
     *     tags={"files"},
     *     description=">-
    For valid response try integer IDs with value >= 1 \ Other
    values will generated exceptions",
     *     operationId="getFileById",
     *     @OAS\Parameter(
     *         name="fileId",
     *         in="path",
     *         description="ID of file that needs to be fetched",
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
     *                 ref="#/components/schemas/File"
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
        return response(FileResource::make(File::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OAS\Put(
     *     path="/api/files/{fileId}",
     *     tags={"files"},
     *     summary="Update an existing file",
     *     operationId="updateFile",
     *     @OAS\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OAS\Response(
     *         response=404,
     *         description="File not found"
     *     ),
     *     @OAS\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     @OAS\Parameter(
     *         name="fileId",
     *         in="path",
     *         description="ID of file to update",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OAS\RequestBody(
     *         description="add file",
     *         @OAS\MediaType(
     *             mediaType="application/json",
     *             @OAS\Schema(
     *                 ref="#/components/schemas/File"
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
        /** @var File $file */
        $file = File::find($id);
        $file->update($request->toArray());

        return response(FileResource::make($file));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OAS\Delete(
     *     path="/api/files/{fileId}",
     *     tags={"files"},
     *     summary="Delete file by ID",
     *     description=">-
    For valid response try integer IDs with positive integer value.\ \
    Negative or non-integer values will generate API errors",
     *     operationId="deleteFile",
     *     @OAS\Parameter(
     *         name="fileId",
     *         in="path",
     *         required=true,
     *         description="ID of the file that needs to be deleted",
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
        return response(File::destroy($id));
    }
}
