<?php

namespace Modules\Communication\Services;

use App\Support\Modules\BaseModuleService;
use Modules\Communication\Repositories\CommunicationChannelRepository;

class CommunicationChannelService extends BaseModuleService
{
    public function __construct(CommunicationChannelRepository $repository)
    {
        parent::__construct($repository, 'communication');
    }
}
