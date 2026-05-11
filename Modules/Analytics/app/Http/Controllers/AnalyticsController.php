<?php

namespace Modules\Analytics\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Analytics\Http\Requests\StoreInsightReportRequest;
use Modules\Analytics\Http\Requests\UpdateInsightReportRequest;
use Modules\Analytics\Http\Resources\InsightReportResource;
use Modules\Analytics\Models\InsightReport;
use Modules\Analytics\Services\InsightReportService;

class AnalyticsController extends Controller
{
    public function __construct(protected InsightReportService $service)
    {
    }

    public function index(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return InsightReportResource::collection($this->service->paginate($request->integer('per_page', 12)));
        }

        return view('analytics::index', $this->service->publicData());
    }

    public function portal()
    {
        return view('analytics::portal', $this->service->portalData(Auth::user()));
    }

    public function erp()
    {
        return view('analytics::erp', $this->service->erpData());
    }

    public function store(StoreInsightReportRequest $request): InsightReportResource
    {
        $this->authorize('create', InsightReport::class);

        return new InsightReportResource($this->service->create($request->validated()));
    }

    public function show(Request $request, int $id)
    {
        $record = $this->service->findOrFail($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return new InsightReportResource($record);
        }

        return view('analytics::index', array_merge($this->service->publicData(), ['focusRecord' => $record]));
    }

    public function update(UpdateInsightReportRequest $request, int $id): InsightReportResource
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('update', $record);

        return new InsightReportResource($this->service->update($id, $request->validated()));
    }

    public function destroy(int $id): JsonResponse
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('delete', $record);
        $this->service->delete($id);

        return response()->json(['message' => 'Deleted']);
    }
}
