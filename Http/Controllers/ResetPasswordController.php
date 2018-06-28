<?php
/**
 * Created by PhpStorm.
 * User: yixin
 * Date: 2018/6/27
 * Time: 9:42
 */

namespace Modules\User\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function updatePassword()
    {
        //如果提交过来的旧的密码正确则允许修改
        if( Hash::check( request('oldPass'), user()->password ) ){
            user()->password = bcrypt( request('password') );
            user()->save();
            return response()->json([
                'success' => true,
                'message' => '密码修改成功'
            ]);
        }
    }
}