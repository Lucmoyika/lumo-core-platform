<?php

namespace Modules\School\Services;

use App\Support\Modules\BaseModuleService;
use Modules\School\Repositories\AcademicProgramRepository;

class AcademicProgramService extends BaseModuleService
{
    public function __construct(AcademicProgramRepository $repository)
    {
        parent::__construct($repository, 'school');
    }
}
