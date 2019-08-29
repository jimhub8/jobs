<?php

namespace App\models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Client extends Model
{
    use SoftDeletes;

    public function scopeUserid($query)
    {
        if (!Auth::user()->hasRole('Super admin')) {
            return $query->where('user_id', Auth::id());
        }
    }

    public function orders()
    {
        return $this->hasMany('App\models\Saleorder', 'sender_id');
    }

    public function cases()
    {
        return $this->hasMany('App\models\Case', 'client_id');
    }
    public function scopeFirmid($query)
    {
        // dd(Auth::user()->hasRole('Super admin'));
        if (!Auth::user()->hasRole('Super admin')) {
            return $query->where('firm_id', Auth::user()->firm_id);
        }
    }
}
