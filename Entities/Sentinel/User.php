<?php

namespace Modules\User\Entities\Sentinel;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use Modules\Sale\Entities\OrderReview;
use Modules\User\Entities\UserInterface;
use Modules\User\Entities\UserOauth;
use Modules\User\Entities\UserToken;
use Modules\User\Presenters\UserPresenter;
use Modules\User\Entities\UserAddress;
use Overtrue\LaravelFollow\Traits\CanFavorite;
use Overtrue\LaravelFollow\Traits\CanFollow;
use Overtrue\LaravelFollow\Traits\CanLike;
use Overtrue\LaravelFollow\Traits\CanSubscribe;
use Overtrue\LaravelFollow\Traits\CanVote;

class User extends EloquentUser implements UserInterface, AuthenticatableContract
{
    use Notifiable, PresentableTrait, Authenticatable,CanFavorite,CanVote,CanSubscribe,CanLike,CanFollow;

    protected $fillable = [
        'email',
        'password',
        'permissions',
        'first_name',
        'last_name'
    ];

    /**
     * {@inheritDoc}
     */
    protected $loginNames = ['email'];

    protected $presenter = UserPresenter::class;

    public function __construct(array $attributes = [])
    {
        $this->loginNames = config('asgard.user.config.login-columns');
        $this->fillable = config('asgard.user.config.fillable');
        if (config()->has('asgard.user.config.presenter')) {
            $this->presenter = config('asgard.user.config.presenter', UserPresenter::class);
        }
        if (config()->has('asgard.user.config.dates')) {
            $this->dates = config('asgard.user.config.dates', []);
        }
        if (config()->has('asgard.user.config.casts')) {
            $this->casts = config('asgard.user.config.casts', []);
        }

        parent::__construct($attributes);
    }

    /**
     * @inheritdoc
     */
    public function hasRoleId($roleId)
    {
        return $this->roles()->whereId($roleId)->count() >= 1;
    }

    /**
     * @inheritdoc
     */
    public function hasRoleSlug($slug)
    {
        return $this->roles()->whereSlug($slug)->count() >= 1;
    }

    /**
     * @inheritdoc
     */
    public function hasRoleName($name)
    {
        return $this->roles()->whereName($name)->count() >= 1;
    }

    /**
     * @inheritdoc
     */
    public function isActivated()
    {
        if (Activation::completed($this)) {
            return true;
        }

        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function api_keys()
    {
        return $this->hasMany(UserToken::class);
    }

    /**
     * @inheritdoc
     */
    public function getFirstApiKey()
    {
        $userToken = $this->api_keys->first();

        if ($userToken === null) {
            return '';
        }

        return $userToken->access_token;
    }

    public function __call($method, $parameters)
    {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.user.config.relations', $method]);

        #i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);
            $bound = $function->bindTo($this);

            return $bound();
        }

        #i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }

    /**
     * @inheritdoc
     */
    public function hasAccess($permission)
    {
        $permissions = $this->getPermissionsInstance();

        return $permissions->hasAccess($permission);
    }

    public function isAdmin()
    {
        foreach ($this->roles()->get() as $role)
        {
            if ($role->name == 'Admin')
            {
                return true;
            }
        }
        return false;
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class,'user_id','id');
    }

    public function reviews()
    {
        return $this->hasMany(OrderReview::class,'user_id','id');
    }

    public function userOauth()
    {
        return $this->hasMany(UserOauth::class,'user_id','id');
    }
}