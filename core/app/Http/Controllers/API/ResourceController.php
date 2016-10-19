<?php

namespace App\Http\Controllers\API;

use App\ROOM;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CreateResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Utils;

/**
 * Class ResourceController
 * @package App\Http\Controllers\API
 */
class ResourceController extends Controller
{
    /**
     * @return Array of all Resource Objects
     */
    public function getAllResources(){
        try {
            $resources = ROOM::all();
            return response()->json($resources, 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json($ex, 500);
        }
    }

    /**
     * @param $id Id of requested Resource
     * @return Resource object of requested Resource
     */
    public function getResource($id){
        try {
            $resource = ROOM::findOrFail($id);
            return response()->json($resource, 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json($ex, 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createResource(CreateResourceRequest $request){

        try {
            ROOM::create($request->all());

            return response()->json(null, 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json($ex, 500);
        }
    }

    /**
     * @param UpdateResourceRequest $request
     * @param $id
     */
    public function updateResource(UpdateResourceRequest $request, $id){
        try {
            $resource = ROOM::findOrFail($id);

            $resource->update($request->all());

            return response()->json($resource, 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json($ex, 500);
        }
    }
}
