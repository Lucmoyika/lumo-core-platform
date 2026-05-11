<?php

namespace Modules\Logistics\Services;

use App\Support\Modules\BaseModuleService;
use Modules\Logistics\Repositories\DeliveryShipmentRepository;

class DeliveryShipmentService extends BaseModuleService
{
    public function __construct(DeliveryShipmentRepository $repository)
    {
        parent::__construct($repository, 'logistics');
    }
}
