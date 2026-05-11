<?php

namespace Modules\Communication\Repositories;

use App\Support\Modules\BaseModuleRepository;
use Modules\Communication\Models\CommunicationChannel;

class CommunicationChannelRepository extends BaseModuleRepository
{
    public function __construct(CommunicationChannel $model)
    {
        parent::__construct($model);
    }
}
