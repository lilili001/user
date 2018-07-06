<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Product\Entities\Product;
use Modules\User\Entities\NewsLetter;
use Modules\User\Http\Requests\NewsletterRequest;

/**
 * Class PublicController
 * @package Modules\User\Http\Controllers
 */
class PublicController extends BasePublicController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function usercenter()
    {
        $pageClass = 'usercenter';
        return view('usercenter.dash',compact('pageClass'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function account()
    {
        return view('usercenter.account');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function order()
    {
        return view('usercenter.order');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reviews()
    {
        $pageClass = 'reviews';
        $reviews = user()->reviews()->get();
        return view('usercenter.reviews',compact('reviews','pageClass'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function favorites()
    {
        $pageClass = 'favorites';
        $favorites = user()->favorites(Product::class)->get();
        return view('usercenter.favorites',compact('favorites','pageClass'));
    }

    /**
     *通知
     */
    public function notifications(Request $request)
    {
        $pageClass = 'notifications';
        $notifications = user()->notifications;

        if( $request->get('all') == null ){
            $notifications = $notifications->filter(function($notification){
                return $notification->read_at == null;
            });
        }

        return view('usercenter.notifications.index',compact('notifications','pageClass'));
    }

    public function notification(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        $redirect_url = \Request::query('redirect_url');
        if( null != $redirect_url ){
            return redirect(\Request::query('redirect_url'));
        }
        return redirect()->back();
    }

    public function newsletter(Request $request,MessageBag $errors)
    {
        $input = $request->all();
        $rule = [
            'email' => 'email|unique:newsletter,email'
        ];
        $message = [
            'email.email' => 'Email format is not correct!',
            'email.unique' => 'Email address already exsists'
        ];

        $validate = Validator::make($input, $rule, $message);

        if (!$validate->passes()) {
            return redirect()->route('newsletter.detail')->withErrors($validate);
        }
        NewsLetter::create(['email'=>$request->get('email')]);
        return redirect()->route('newsletter.detail');
    }

    public function newsletter_detail()
    {
        return view('usercenter.newsletter');
    }
}