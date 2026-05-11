<?php

namespace Modules\Companies\Repositories;

use App\Support\Modules\BaseModuleRepository;
use Modules\Companies\Models\CompanyProfile;

class CompanyProfileRepository extends BaseModuleRepository
{
    public function __construct(CompanyProfile $model)
    {
        parent::__construct($model);
    }
}
