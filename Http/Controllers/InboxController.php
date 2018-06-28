<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Notifications\DatabaseNotification;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Product\Entities\Product;
use Modules\Sale\Entities\ProductReviewReply;

/**
 * Class PublicController
 * @package Modules\User\Http\Controllers
 */
class InboxController extends BasePublicController
{
    public function show($dialog_id)
    {
        $messages = ProductReviewReply::where('dialog_id',$dialog_id)->with([
            'fromUser' => function($query){
                return $query->select(['id','first_name' ]);
            },
            'toUser' =>function($query){
                return $query->select(['id','first_name' ]);
            }
        ])->latest()->get();

        $messages->markAsRead();
        return view('usercenter.notifications.message.show',compact('messages','dialog_id'));
    }
}