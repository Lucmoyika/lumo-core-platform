<?php

namespace Modules\School\Repositories;

use App\Support\Modules\BaseModuleRepository;
use Modules\School\Models\AcademicProgram;

class AcademicProgramRepository extends BaseModuleRepository
{
    public function __construct(AcademicProgram $model)
    {
        parent::__construct($model);
    }
}
