<?php

namespace App;

use Illuminate\Auth\Authenticatable;
//use Vinelab\NeoEloquent\Eloquent\Relations\MorphMany;
//use Vinelab\NeoEloquent\Eloquent\Edges\EdgeIn;
//use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;
use NeoEloquent;
use App\Phone;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends NeoEloquent implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $label = 'User';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	public function terms()
    {
        return $this->hasMany('App\Term', 'CREATED');
    }
}
