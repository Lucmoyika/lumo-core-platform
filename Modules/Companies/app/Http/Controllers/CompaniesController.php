<?php

namespace Modules\Companies\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Companies\Http\Requests\StoreCompanyProfileRequest;
use Modules\Companies\Http\Requests\UpdateCompanyProfileRequest;
use Modules\Companies\Http\Resources\CompanyProfileResource;
use Modules\Companies\Models\CompanyProfile;
use Modules\Companies\Services\CompanyProfileService;

class CompaniesController extends Controller
{
    public function __construct(protected CompanyProfileService $service)
    {
    }

    public function index(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return CompanyProfileResource::collection($this->service->paginate($request->integer('per_page', 12)));
        }

        return view('companies::index', $this->service->publicData());
    }

    public function portal()
    {
        return view('companies::portal', $this->service->portalData(Auth::user()));
    }

    public function erp()
    {
        return view('companies::erp', $this->service->erpData());
    }

    public function store(StoreCompanyProfileRequest $request): CompanyProfileResource
    {
        $this->authorize('create', CompanyProfile::class);

        return new CompanyProfileResource($this->service->create($request->validated()));
    }

    public function show(Request $request, int $id)
    {
        $record = $this->service->findOrFail($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return new CompanyProfileResource($record);
        }

        return view('companies::index', array_merge($this->service->publicData(), ['focusRecord' => $record]));
    }

    public function update(UpdateCompanyProfileRequest $request, int $id): CompanyProfileResource
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('update', $record);

        return new CompanyProfileResource($this->service->update($id, $request->validated()));
    }

    public function destroy(int $id): JsonResponse
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('delete', $record);
        $this->service->delete($id);

        return response()->json(['message' => 'Deleted']);
    }
}
