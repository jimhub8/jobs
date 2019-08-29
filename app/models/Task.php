<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    public $with =  ['user'];

    public function user()
    {
        return $this->belongsTo('App\User', 'assigned_to');
    }
    public function scopeFirmid($query)
    {
        // dd(Auth::user()->hasRole('Super admin'));
        if (!Auth::user()->hasRole('Super admin')) {
            return $query->where('firm_id', Auth::user()->firm_id);
        }
    }
}
