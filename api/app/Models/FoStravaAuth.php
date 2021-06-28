<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class FoStravaAuth extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $timestamps = true;
    const CREATED_AT = 'fsa_created_date';
    const UPDATED_AT = 'fsa_updated_date';

    protected $fillable = [
      'fsa_fu_id',
      'fsa_token_type',
      'fsa_expires_at',
      'fsa_expires_in',
      'fsa_refresh_token',
      'fsa_access_token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'fsa_token_type', 'fsa_refresh_token', 'fsa_access_token'
    ];

    protected $table = 'fo_strava_auth';
}
