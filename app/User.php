<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes;
    use HasRoles;

	public $with = ['roles'];
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all user permissions.
     *
     * @return bool
     */
    public function getAllPermissionsAttribute()
    {
        return $this->getAllPermissions();
    }


    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('M-d-Y');
    }


    public function scopeFirmid($query)
    {
        // dd(Auth::user()->hasRole('Admin'));
        if (!Auth::user()->hasRole('Super admin')) {
            // return $query->where('firm_id', Auth::user()->firm_id);
        }
    }
}
