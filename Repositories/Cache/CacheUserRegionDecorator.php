<?php

namespace Modules\User\Repositories\Cache;

use Modules\User\Repositories\UserRegionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheUserRegionDecorator extends BaseCacheDecorator implements UserRegionRepository
{
    public function __construct(UserRegionRepository $userregion)
    {
        parent::__construct();
        $this->entityName = 'user.userregions';
        $this->repository = $userregion;
    }
}
