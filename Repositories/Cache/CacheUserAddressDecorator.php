<?php

namespace Modules\User\Repositories\Cache;

use Modules\User\Repositories\UserAddressRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheUserAddressDecorator extends BaseCacheDecorator implements UserAddressRepository
{
    public function __construct(UserAddressRepository $useraddress)
    {
        parent::__construct();
        $this->entityName = 'user.useraddresses';
        $this->repository = $useraddress;
    }
}
