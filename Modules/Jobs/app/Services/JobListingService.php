<?php

namespace Modules\Jobs\Services;

use App\Support\Modules\BaseModuleService;
use Modules\Jobs\Repositories\JobListingRepository;

class JobListingService extends BaseModuleService
{
    public function __construct(JobListingRepository $repository)
    {
        parent::__construct($repository, 'jobs');
    }
}
