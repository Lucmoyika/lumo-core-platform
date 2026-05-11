<?php

namespace Modules\Ecommerce\Services;

use App\Support\Modules\BaseModuleService;
use Modules\Ecommerce\Repositories\CatalogProductRepository;

class CatalogProductService extends BaseModuleService
{
    public function __construct(CatalogProductRepository $repository)
    {
        parent::__construct($repository, 'ecommerce');
    }
}
