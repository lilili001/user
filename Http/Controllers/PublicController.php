<?php

namespace Modules\User\Http\Controllers;

use Modules\Core\Http\Controllers\BasePublicController;

class PublicController extends BasePublicController
{
    public function usercenter()
    {
        return view('usercenter.dash');
    }
    public function account()
    {
        return view('usercenter.account');
    }
    public function order()
    {
        return view('usercenter.order');
    }
    public function reviews()
    {
        return view('usercenter.reviews');
    }
    public function favorites()
    {
        return view('usercenter.favorites');
    }
}