<?php

namespace Modules\School\Services;

use App\Support\Modules\BaseModuleService;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\School\Models\AcademicProgram;
use Modules\School\Repositories\AcademicProgramRepository;

class AcademicProgramService extends BaseModuleService
{
    public function __construct(AcademicProgramRepository $repository)
    {
        parent::__construct($repository, 'school');
    }

    public function publicData(array $filters = []): array
    {
        return [
            'module' => $this->module(),
            'records' => $this->repository->publicItems(6, $filters),
            'stats' => $this->repository->stats($filters),
            'filters' => $filters,
        ];
    }

    public function portalData(?User $user = null, array $filters = []): array
    {
        return [
            'module' => $this->module(),
            'records' => $this->repository->publicItems(6, $filters),
            'stats' => $this->repository->stats($filters),
            'filters' => $filters,
            'user' => $user,
        ];
    }

    public function erpData(array $filters = []): array
    {
        return [
            'module' => $this->module(),
            'records' => $this->paginate(10, $filters),
            'stats' => $this->repository->stats($filters),
            'filters' => $filters,
        ];
    }

    public function paginate(int $perPage = 12, array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage, $filters);
    }

    public function create(array $attributes): AcademicProgram
    {
        return $this->repository->create($attributes);
    }

    public function update(int|string $id, array $attributes): AcademicProgram
    {
        return $this->repository->update($id, $attributes);
    }
}
