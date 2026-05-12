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
            $attributes['slug'] = Str::slug(($attributes['name'] ?? 'programme').'-'.Str::random(6));
        }

        return parent::create($attributes);
    }

    public function update(int|string $id, array $attributes): Model
    {
        if (empty($attributes['slug'])) {
            $attributes['slug'] = Str::slug(($attributes['name'] ?? 'programme').'-'.Str::random(6));
        }

        return parent::update($id, $attributes);
    }
}
