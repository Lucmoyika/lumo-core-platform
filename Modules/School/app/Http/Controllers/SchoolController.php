<?php

namespace Modules\School\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\School\Http\Requests\StoreAcademicProgramRequest;
use Modules\School\Http\Requests\UpdateAcademicProgramRequest;
use Modules\School\Http\Resources\AcademicProgramResource;
use Modules\School\Models\AcademicProgram;
use Modules\School\Services\AcademicProgramService;

class SchoolController extends Controller
{
    public function __construct(protected AcademicProgramService $service)
    {
    }

    public function index(Request $request)
    {
        $filters = $this->extractFilters($request);
        $perPage = max(1, min(100, $request->integer('per_page', 12)));

        if ($request->expectsJson() || $request->is('api/*')) {
            return AcademicProgramResource::collection($this->service->paginate($perPage, $filters));
        }

        return view('school::index', $this->service->publicData($filters));
    }

    public function portal(Request $request)
    {
        return view('school::portal', $this->service->portalData(Auth::user(), $this->extractFilters($request)));
    }

    public function erp(Request $request)
    {
        return view('school::erp', $this->service->erpData($this->extractFilters($request)));
    }

    public function store(StoreAcademicProgramRequest $request): AcademicProgramResource
    {
        $this->authorize('create', AcademicProgram::class);

        return new AcademicProgramResource($this->service->create($request->validated()));
    }

    public function show(Request $request, int $id)
    {
        $record = $this->service->findOrFail($id);
        $filters = $this->extractFilters($request);

        if ($request->expectsJson() || $request->is('api/*')) {
            return new AcademicProgramResource($record);
        }

        return view('school::index', array_merge($this->service->publicData($filters), ['focusRecord' => $record]));
    }

    public function update(UpdateAcademicProgramRequest $request, int $id): AcademicProgramResource
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('update', $record);

        return new AcademicProgramResource($this->service->update($id, $request->validated()));
    }

    public function destroy(int $id): JsonResponse
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('delete', $record);
        $this->service->delete($id);

        return response()->json(['message' => 'Deleted']);
    }

    protected function extractFilters(Request $request): array
    {
        return [
            'q' => $request->string('q')->toString(),
            'status' => $request->string('status')->toString(),
            'level' => $request->string('level')->toString(),
            'admission_open' => $request->query('admission_open'),
        ];
    }
}
