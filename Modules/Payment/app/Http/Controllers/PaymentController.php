<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Payment\Http\Requests\StoreWalletTransactionRequest;
use Modules\Payment\Http\Requests\UpdateWalletTransactionRequest;
use Modules\Payment\Http\Resources\WalletTransactionResource;
use Modules\Payment\Models\WalletTransaction;
use Modules\Payment\Services\WalletTransactionService;

class PaymentController extends Controller
{
    public function __construct(protected WalletTransactionService $service)
    {
    }

    public function index(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return WalletTransactionResource::collection($this->service->paginate($request->integer('per_page', 12)));
        }

        return view('payment::index', $this->service->publicData());
    }

    public function portal()
    {
        return view('payment::portal', $this->service->portalData(Auth::user()));
    }

    public function erp()
    {
        return view('payment::erp', $this->service->erpData());
    }

    public function store(StoreWalletTransactionRequest $request): WalletTransactionResource
    {
        $this->authorize('create', WalletTransaction::class);

        return new WalletTransactionResource($this->service->create($request->validated()));
    }

    public function show(Request $request, int $id)
    {
        $record = $this->service->findOrFail($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return new WalletTransactionResource($record);
        }

        return view('payment::index', array_merge($this->service->publicData(), ['focusRecord' => $record]));
    }

    public function update(UpdateWalletTransactionRequest $request, int $id): WalletTransactionResource
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('update', $record);

        return new WalletTransactionResource($this->service->update($id, $request->validated()));
    }

    public function destroy(int $id): JsonResponse
    {
        $record = $this->service->findOrFail($id);
        $this->authorize('delete', $record);
        $this->service->delete($id);

        return response()->json(['message' => 'Deleted']);
    }
}
