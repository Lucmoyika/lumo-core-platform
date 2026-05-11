<?php

namespace Modules\Logistics\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Logistics\Http\Requests\StoreDeliveryShipmentRequest;
use Modules\Logistics\Http\Requests\UpdateDeliveryShipmentRequest;
use Modules\Logistics\Http\Resources\DeliveryShipmentResource;
use Modules\Logistics\Models\DeliveryShipment;
use Modules\Logistics\Services\DeliveryShipmentService;

class LogisticsController extends Controller
{
    public function __construct(protected DeliveryShipmentService $service)
    {
    }

    public function index(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return DeliveryShipmentResource::collection($this->service->paginate($request->integer('per_page', 12)));
        }

        return view('logistics::index', $this->service->publicData());
    }

    public function portal()
    {
        return view('logistics::portal', $this->service->portalData(Auth::user()));
    }

    public function erp()
    {
        return view('logistics::erp', $this->service->erpData());
    }

    public function store(StoreDeliveryShipmentRequest $request): DeliveryShipmentResource
    {
        $this->authorize('create', DeliveryShipment::class);

        return new DeliveryShipmentResource($this->service->create($request->validated()));
    }

    public function show(Request $request, int $id)
    {
        $record = $this->service->findOrFail($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return new DeliveryShipmentResource($record);
        }

        return view('logistics::index', array_merge($this->service->publicData(), ['focusRecord' => $record]));
    }

    public function update(UpdateDeliveryShipmentRequest $request, int $id): DeliveryShipmentResource
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('update', $record);

        return new DeliveryShipmentResource($this->service->update($id, $request->validated()));
    }

    public function destroy(int $id): JsonResponse
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('delete', $record);
        $this->service->delete($id);

        return response()->json(['message' => 'Deleted']);
    }
}
