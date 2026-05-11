<?php

namespace Modules\Jobs\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Jobs\Http\Requests\StoreJobListingRequest;
use Modules\Jobs\Http\Requests\UpdateJobListingRequest;
use Modules\Jobs\Http\Resources\JobListingResource;
use Modules\Jobs\Models\JobListing;
use Modules\Jobs\Services\JobListingService;

class JobsController extends Controller
{
    public function __construct(protected JobListingService $service)
    {
    }

    public function index(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return JobListingResource::collection($this->service->paginate($request->integer('per_page', 12)));
        }

        return view('jobs::index', $this->service->publicData());
    }

    public function portal()
    {
        return view('jobs::portal', $this->service->portalData(Auth::user()));
    }

    public function erp()
    {
        return view('jobs::erp', $this->service->erpData());
    }

    public function store(StoreJobListingRequest $request): JobListingResource
    {
        $this->authorize('create', JobListing::class);

        return new JobListingResource($this->service->create($request->validated()));
    }

    public function show(Request $request, int $id)
    {
        $record = $this->service->findOrFail($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return new JobListingResource($record);
        }

        return view('jobs::index', array_merge($this->service->publicData(), ['focusRecord' => $record]));
    }

    public function update(UpdateJobListingRequest $request, int $id): JobListingResource
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('update', $record);

        return new JobListingResource($this->service->update($id, $request->validated()));
    }

    public function destroy(int $id): JsonResponse
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('delete', $record);
        $this->service->delete($id);

        return response()->json(['message' => 'Deleted']);
    }
}
