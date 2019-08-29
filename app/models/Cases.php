<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cases extends Model
{
    public $with = ['events', 'client', 'firm', 'status', 'practice_area', 'leading_attoney'];
    public function events()
    {
        return $this->hasMany('App\models\Event', 'case_id');
    }

    public function client()
    {
        return $this->belongsTo('App\models\Client', 'client_id');
    }
    public function firm()
    {
        return $this->belongsTo('App\models\Firm', 'firm_id');
    }
    public function status()
    {
        return $this->belongsTo('App\models\Status', 'status');
    }
    public function practice_area()
    {
        return $this->belongsTo('App\models\Practice', 'practice_area');
    }
    public function leading_attoney()
    {
        return $this->belongsTo('App\User', 'leading_attoney');
    }

    public function scopeFirmid($query)
    {
        // dd(Auth::user()->hasRole('Super admin'));
        if (!Auth::user()->hasRole('Super admin')) {
            return $query->where('firm_id', Auth::user()->firm_id);
        }
    }
}
