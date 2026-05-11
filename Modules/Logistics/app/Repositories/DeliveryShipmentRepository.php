<?php

namespace Modules\Logistics\Repositories;

use App\Support\Modules\BaseModuleRepository;
use Modules\Logistics\Models\DeliveryShipment;

class DeliveryShipmentRepository extends BaseModuleRepository
{
    public function __construct(DeliveryShipment $model)
    {
        parent::__construct($model);
    }
}
