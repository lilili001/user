<?php

namespace Modules\User\Http\Controllers;

use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Product\Entities\Product;

class PublicController extends BasePublicController
{
    public function usercenter()
    {
        $pageClass = 'usercenter';
        return view('usercenter.dash',compact('pageClass'));
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
        $pageClass = 'reviews';
        $reviews = user()->reviews()->get();
        return view('usercenter.reviews',compact('reviews','pageClass'));
    }
    public function favorites()
    {
        $pageClass = 'favorites';
        $favorites = user()->favorites(Product::class)->get();
        return view('usercenter.favorites',compact('favorites','pageClass'));
    }
}