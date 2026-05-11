<?php

namespace App\Support\Modules;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class BaseModuleService
{
    public function __construct(
        protected BaseModuleRepository $repository,
        protected string $moduleKey,
    ) {}

    public function module(): array
    {
        return ModuleRegistry::find($this->moduleKey);
    }

    public function publicData(): array
    {
        return [
            'module' => $this->module(),
            'records' => $this->repository->publicItems(),
            'stats' => $this->repository->stats(),
        ];
    }

    public function portalData(?User $user = null): array
    {
        return [
            'module' => $this->module(),
            'records' => $this->repository->publicItems(),
            'stats' => $this->repository->stats(),
            'user' => $user,
        ];
    }

    public function erpData(): array
    {
        return [
            'module' => $this->module(),
            'records' => $this->paginate(10),
            'stats' => $this->repository->stats(),
        ];
    }

    public function paginate(int $perPage = 12): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function findOrFail(int|string $id): Model
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $attributes): Model
    {
        return $this->repository->create($attributes);
    }

    public function update(int|string $id, array $attributes): Model
    {
        return $this->repository->update($id, $attributes);
    }

    public function delete(int|string $id): void
    {
        $this->repository->delete($id);
    }
}
