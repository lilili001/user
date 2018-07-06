<?php

namespace Modules\User\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model
{
    protected $table = 'newsletter';
    protected $fillable = [
         'email'
    ];
}
