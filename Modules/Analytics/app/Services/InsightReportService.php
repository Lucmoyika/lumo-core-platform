<?php

namespace Modules\Analytics\Services;

use App\Support\Modules\BaseModuleService;
use Modules\Analytics\Repositories\InsightReportRepository;

class InsightReportService extends BaseModuleService
{
    public function __construct(InsightReportRepository $repository)
    {
        parent::__construct($repository, 'analytics');
    }
}
