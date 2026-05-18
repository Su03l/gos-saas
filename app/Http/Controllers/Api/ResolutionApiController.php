<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResolutionResource;
use App\Models\Resolution;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ResolutionApiController extends Controller
{
    /**
     * Display a listing of resolutions.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $resolutions = Resolution::with(['committee', 'executionTasks.assignee'])->paginate();

        return ResolutionResource::collection($resolutions);
    }

    /**
     * Display the specified resolution.
     */
    public function show(Resolution $resolution): ResolutionResource
    {
        $resolution->load(['committee', 'executionTasks.assignee']);

        return new ResolutionResource($resolution);
    }
}
