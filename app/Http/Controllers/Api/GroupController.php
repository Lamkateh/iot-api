<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GroupPreviewResource;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->sendResponse(GroupPreviewResource::collection(Group::all()), "Groups successfully retrieved");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required'],
            'period' => ['required'],
            'start' => ['required'],
            'end' => ['required'],
        ]);

        $group = Group::create([
            'name' => $request->name,
            'period' => $request->period,
            'start' => $request->start,
            'end' => $request->end,
        ]);

        return $this->sendResponse(new GroupPreviewResource($group), "Group successfully created");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $group = Group::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->sendError($e, ['This group does not exist']);
        }

        return $this->sendResponse(new GroupResource($group), 'Group successfully retrieved');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
