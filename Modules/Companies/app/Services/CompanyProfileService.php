<?php

namespace Modules\Companies\Services;

use App\Support\Modules\BaseModuleService;
use Modules\Companies\Repositories\CompanyProfileRepository;

class CompanyProfileService extends BaseModuleService
{
    public function __construct(CompanyProfileRepository $repository)
    {
        parent::__construct($repository, 'companies');
    }
}
