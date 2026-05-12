<?php

namespace Modules\School\Services;

use App\Support\Modules\BaseModuleService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\School\Repositories\AcademicProgramRepository;

class AcademicProgramService extends BaseModuleService
{
    public function __construct(AcademicProgramRepository $repository)
    {
        parent::__construct($repository, 'school');
    }

    public function create(array $attributes): Model
    {
        if (empty($attributes['slug'])) {
            $attributes['slug'] = $this->generateSlug($attributes['name'] ?? $this->moduleKey);
        }

        return parent::create($attributes);
    }

    public function update(int|string $id, array $attributes): Model
    {
        if (empty($attributes['slug'])) {
            // Preserve the existing slug to avoid breaking URLs unnecessarily.
            $existing = $this->repository->findOrFail($id);
            $attributes['slug'] = $existing->slug;
        }

        return parent::update($id, $attributes);
    }

    private function generateSlug(string $base): string
    {
        return Str::slug($base.'-'.Str::random(6));
    }
}
