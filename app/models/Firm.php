<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Firm extends Model
{
    public function cases()
    {
        return $this->hasMany('App\models\Case', 'client_id');
    }

}
