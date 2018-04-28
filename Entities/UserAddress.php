<?php

namespace Modules\User\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'customer_address';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'telephone',
        'country',
        'state',
        'city',
        'country_label',
        'state_label',
        'city_label',
        'street',
        'state',
        'zip',
        'user_id',
        'created_at',
        'updated_at',
        'is_default'
    ];
}
