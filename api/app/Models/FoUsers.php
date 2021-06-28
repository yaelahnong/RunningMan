<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class FoUsers extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $timestamps = true;
    const CREATED_AT = 'fu_created_date';
    const UPDATED_AT = 'fu_updated_date';
    
    protected $fillable = [
      'fu_fsa_id',
      'fu_athlete_id',
      'fu_full_name',
      'fu_email_address',
      'fu_phone',
      'fu_username',
      'fu_password' ,
      'fu_token', 
      'fu_strava_auth', 
      'fu_reset_password_token', 
      'fu_reset_password_expires', 
      'fu_is_active',
      'fu_created_date' ,
      'fu_updated_date'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'fu_password', 'fu_token', 'fu_reset_password_token', 'fu_reset_password_expires',
    ];

    protected $table = 'fo_users';
}
