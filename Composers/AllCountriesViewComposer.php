<?php

namespace Modules\User\Composers;

use Illuminate\Contracts\View\View;
use Modules\User\Contracts\Authentication;
use Modules\User\Entities\UserRegion;

class AllCountriesViewComposer
{
    /**
     * @var Authentication
     */
    private $auth;

    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function compose(View $view)
    {
        $countries = UserRegion::where('level',2)->get()->toArray();
        $view->with('all_countries', $countries);
    }
}
