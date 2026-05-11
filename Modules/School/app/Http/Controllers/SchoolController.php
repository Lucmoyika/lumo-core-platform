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
        if ($request->expectsJson() || $request->is('api/*')) {
            return AcademicProgramResource::collection($this->service->paginate($request->integer('per_page', 12)));
        }

        return view('school::index', $this->service->publicData());
    }

    public function portal()
    {
        return view('school::portal', $this->service->portalData(Auth::user()));
    }

    public function erp()
    {
        return view('school::erp', $this->service->erpData());
    }

    public function store(StoreAcademicProgramRequest $request): AcademicProgramResource
    {
        $this->authorize('create', AcademicProgram::class);

        return new AcademicProgramResource($this->service->create($request->validated()));
    }

    public function show(Request $request, int $id)
    {
        $record = $this->service->findOrFail($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return new AcademicProgramResource($record);
        }

        return view('school::index', array_merge($this->service->publicData(), ['focusRecord' => $record]));
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
}
