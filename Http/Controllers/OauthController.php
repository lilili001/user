<?php
/**
 * Created by PhpStorm.
 * User: yixin
 * Date: 2018/6/27
 * Time: 15:28
 */

namespace Modules\User\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\User\Entities\Sentinel\User;
use Modules\User\Repositories\Sentinel\SentinelUserRepository;

class OauthController extends BasePublicController
{
    public $user;
    public function __construct(SentinelUserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * 重定向用户信息到 GitHub 认证页面。
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($type)
    {
       //return Socialite::driver('github')->redirect();
        return Socialite::with($type)->redirect();
    }

    /**
     * 获取来自 GitHub 返回的用户信息。
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($type)
    {
        $clientUser = Socialite::driver($type)->user();

        //$user = Socialite::driver($type)->userFromToken('9CD1464283020E832F33711EF856BBD0');
        dump($clientUser);
        dump($clientUser->getId());
        dump($clientUser->getNickname());
        dump($clientUser->getAvatar());
        $user = User::where('account_id',$clientUser->getId() )->get()->first();

        //如果用户不存在则创建用户
        if (!$user){
            try{
                $data = [
                    'account_id' => $clientUser->getId(),
                    'password' => bcrypt(str_random(16)),
                    'avatar' => $clientUser->getAvatar(),
                    'login_type'=> $type,
                    'nickname' => $clientUser->getNickname()
                ];

                DB::transaction(function()use($data,$clientUser,$type){
                    //一个用户可以对应多个oauth,即绑定第三方到当前账户
                    $user = $this->user->create( $data , true );
                    $dataOauth = [
                        'nickname' => $clientUser->getNickname(),
                        'social_id' => $clientUser->getId(),
                        'social_token' => $clientUser->token,
                        'login_type'=> $type
                    ];
                    $user->userOauth()->create($dataOauth);
                });
            }catch (Exception $e){
                return $e->getMessage();
            }
        }
        Auth::login($user);
        return redirect('/');
    }
}