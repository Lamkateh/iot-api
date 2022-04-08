<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\MeasureResource;
use App\Models\Group;
use App\Models\Measure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeasureController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'values' => ['required'],
        ]);

        $group = Group::where('start', '<=', now())->where('end', '>=', now())->first();

        $measure = Measure::create([
            "values" => $request->get('values'),
            'group_id' => $group->id,
        ]);

        return $this->sendResponse(new MeasureResource($measure), 'Measure created successfully.');
    }
}
