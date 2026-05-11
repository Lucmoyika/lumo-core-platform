<?php

namespace Modules\Analytics\Repositories;

use App\Support\Modules\BaseModuleRepository;
use Modules\Analytics\Models\InsightReport;

class InsightReportRepository extends BaseModuleRepository
{
    public function __construct(InsightReport $model)
    {
        parent::__construct($model);
    }
}
