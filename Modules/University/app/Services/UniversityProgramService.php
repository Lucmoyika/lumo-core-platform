<?php

namespace Modules\University\Services;

use App\Support\Modules\BaseModuleService;
use Modules\University\Repositories\UniversityProgramRepository;

class UniversityProgramService extends BaseModuleService
{
    public function __construct(UniversityProgramRepository $repository)
    {
        parent::__construct($repository, 'university');
    }
}
