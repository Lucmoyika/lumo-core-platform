<?php

namespace Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Ecommerce\Http\Requests\StoreCatalogProductRequest;
use Modules\Ecommerce\Http\Requests\UpdateCatalogProductRequest;
use Modules\Ecommerce\Http\Resources\CatalogProductResource;
use Modules\Ecommerce\Models\CatalogProduct;
use Modules\Ecommerce\Services\CatalogProductService;

class EcommerceController extends Controller
{
    public function __construct(protected CatalogProductService $service)
    {
    }

    public function index(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return CatalogProductResource::collection($this->service->paginate($request->integer('per_page', 12)));
        }

        return view('ecommerce::index', $this->service->publicData());
    }

    public function portal()
    {
        return view('ecommerce::portal', $this->service->portalData(Auth::user()));
    }

    public function erp()
    {
        return view('ecommerce::erp', $this->service->erpData());
    }

    public function store(StoreCatalogProductRequest $request): CatalogProductResource
    {
        $this->authorize('create', CatalogProduct::class);

        return new CatalogProductResource($this->service->create($request->validated()));
    }

    public function show(Request $request, int $id)
    {
        $record = $this->service->findOrFail($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return new CatalogProductResource($record);
        }

        return view('ecommerce::index', array_merge($this->service->publicData(), ['focusRecord' => $record]));
    }

    public function update(UpdateCatalogProductRequest $request, int $id): CatalogProductResource
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('update', $record);

        return new CatalogProductResource($this->service->update($id, $request->validated()));
    }

    public function destroy(int $id): JsonResponse
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('delete', $record);
        $this->service->delete($id);

        return response()->json(['message' => 'Deleted']);
    }
}
