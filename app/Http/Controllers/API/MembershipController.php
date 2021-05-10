<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MembershipResource;


class MembershipController extends Controller
{ /**
    * @OA\Get(
    *      path="/api/membership",
    *      operationId="getMembershipList",
    *      tags={"Membership"},
    *      summary="Get list of memberships",
    *      description="Returns list of memberships",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
    *      @OA\Response(
    *          response=401,
    *          description="Unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      )
    *     )
    */
    public function index()
    {
        $memberships = Membership::all();
        return response([ 'memberships' => MembershipResource::collection($memberships), 'message' => 'Retrieved successfully'], 200);

    }

    /**
     * @OA\Post(
     *      path="/membership",
     *      operationId="storeMembership",
     *      tags={"Membership"},
     *      summary="Store new membership",
     *      description="Returns membership data",
     *      @OA\Parameter(
     *          name="user_id",
     *          description="user id",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="status",
     *          description="status",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="position",
     *          description="position",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'status' => 'required|max:255',
            'position' => 'required|max:255',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $user = Auth::guard('api')->user();
        $data['user_id'] = $user->id;
        $membership = Membership::create($data);

        return response([ 'membership' => new MembershipResource($membership), 'message' => 'Created successfully'], 200);
    }

    /**
     * @OA\Get(
     *      path="/membership/{id}",
     *      operationId="getMembershipById",
     *      tags={"Membership"},
     *      summary="Get membership information",
     *      description="Returns membership data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Membership id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show(Membership $membership)
    {
        return response([ 'membership' => new MembershipResource($membership), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * @OA\Put(
     *      path="/membership/{id}",
     *      operationId="updateMembership",
     *      tags={"Membership"},
     *      summary="Update existing membership",
     *      description="Returns updated membership data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Membership id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="user_id",
     *          description="user id",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="status",
     *          description="status",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="position",
     *          description="position",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(Request $request, Membership $membership)
    {

        $membership->update($request->all());

        return response([ 'membership' => new MembershipResource($membership), 'message' => 'Retrieved successfully'], 200);

    }


    /**
     * @OA\Delete(
     *      path="/membership/{id}",
     *      operationId="deleteMembership",
     *      tags={"Membership"},
     *      summary="Delete existing membership",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Membership id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy(Membership $membership)
    {
        $membership->delete();

        return response(['message' => 'Deleted']);
    }
}
