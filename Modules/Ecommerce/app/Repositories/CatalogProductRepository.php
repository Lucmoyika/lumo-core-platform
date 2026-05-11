<?php

namespace Modules\Ecommerce\Repositories;

use App\Support\Modules\BaseModuleRepository;
use Modules\Ecommerce\Models\CatalogProduct;

class CatalogProductRepository extends BaseModuleRepository
{
    public function __construct(CatalogProduct $model)
    {
        parent::__construct($model);
    }
}
