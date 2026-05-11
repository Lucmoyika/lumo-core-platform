<?php

namespace Modules\University\Repositories;

use App\Support\Modules\BaseModuleRepository;
use Modules\University\Models\UniversityProgram;

class UniversityProgramRepository extends BaseModuleRepository
{
    public function __construct(UniversityProgram $model)
    {
        parent::__construct($model);
    }
}
