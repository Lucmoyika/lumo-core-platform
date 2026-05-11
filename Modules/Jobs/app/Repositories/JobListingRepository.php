<?php

namespace Modules\Jobs\Repositories;

use App\Support\Modules\BaseModuleRepository;
use Modules\Jobs\Models\JobListing;

class JobListingRepository extends BaseModuleRepository
{
    public function __construct(JobListing $model)
    {
        parent::__construct($model);
    }
}
