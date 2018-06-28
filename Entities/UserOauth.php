<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;

class UserOauth extends Model
{
    protected $table = 'oauth';
    public $timestamps = false;
    protected $fillable = [
        'social_id',
        'social_token',
        'user_id',
        'nickname',
        'login_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
