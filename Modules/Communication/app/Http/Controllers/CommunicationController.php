<?php

namespace Modules\Communication\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Communication\Http\Requests\StoreCommunicationChannelRequest;
use Modules\Communication\Http\Requests\UpdateCommunicationChannelRequest;
use Modules\Communication\Http\Resources\CommunicationChannelResource;
use Modules\Communication\Models\CommunicationChannel;
use Modules\Communication\Services\CommunicationChannelService;

class CommunicationController extends Controller
{
    public function __construct(protected CommunicationChannelService $service)
    {
    }

    public function index(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return CommunicationChannelResource::collection($this->service->paginate($request->integer('per_page', 12)));
        }

        return view('communication::index', $this->service->publicData());
    }

    public function portal()
    {
        return view('communication::portal', $this->service->portalData(Auth::user()));
    }

    public function erp()
    {
        return view('communication::erp', $this->service->erpData());
    }

    public function store(StoreCommunicationChannelRequest $request): CommunicationChannelResource
    {
        $this->authorize('create', CommunicationChannel::class);

        return new CommunicationChannelResource($this->service->create($request->validated()));
    }

    public function show(Request $request, int $id)
    {
        $record = $this->service->findOrFail($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return new CommunicationChannelResource($record);
        }

        return view('communication::index', array_merge($this->service->publicData(), ['focusRecord' => $record]));
    }

    public function update(UpdateCommunicationChannelRequest $request, int $id): CommunicationChannelResource
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('update', $record);

        return new CommunicationChannelResource($this->service->update($id, $request->validated()));
    }

    public function destroy(int $id): JsonResponse
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('delete', $record);
        $this->service->delete($id);

        return response()->json(['message' => 'Deleted']);
    }
}
