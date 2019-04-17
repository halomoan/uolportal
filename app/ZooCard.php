<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZooCard extends Model
{
    protected $dates = ['fordate'];
    public $primaryKey  = 'user_id';
}
