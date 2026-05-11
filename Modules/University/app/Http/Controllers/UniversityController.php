<?php

namespace Modules\University\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\University\Http\Requests\StoreUniversityProgramRequest;
use Modules\University\Http\Requests\UpdateUniversityProgramRequest;
use Modules\University\Http\Resources\UniversityProgramResource;
use Modules\University\Models\UniversityProgram;
use Modules\University\Services\UniversityProgramService;

class UniversityController extends Controller
{
    public function __construct(protected UniversityProgramService $service)
    {
    }

    public function index(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return UniversityProgramResource::collection($this->service->paginate($request->integer('per_page', 12)));
        }

        return view('university::index', $this->service->publicData());
    }

    public function portal()
    {
        return view('university::portal', $this->service->portalData(Auth::user()));
    }

    public function erp()
    {
        return view('university::erp', $this->service->erpData());
    }

    public function store(StoreUniversityProgramRequest $request): UniversityProgramResource
    {
        $this->authorize('create', UniversityProgram::class);

        return new UniversityProgramResource($this->service->create($request->validated()));
    }

    public function show(Request $request, int $id)
    {
        $record = $this->service->findOrFail($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return new UniversityProgramResource($record);
        }

        return view('university::index', array_merge($this->service->publicData(), ['focusRecord' => $record]));
    }

    public function update(UpdateUniversityProgramRequest $request, int $id): UniversityProgramResource
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('update', $record);

        return new UniversityProgramResource($this->service->update($id, $request->validated()));
    }

    public function destroy(int $id): JsonResponse
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('delete', $record);
        $this->service->delete($id);

        return response()->json(['message' => 'Deleted']);
    }
}
