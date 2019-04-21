<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZooCard extends Model
{
    protected $dates = ['fordate'];
    public $primaryKey  = 'id';

    protected $fillable = [
        'user_id','fordate','status',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function userprofile(){
        return $this->hasManyThrough(
            'App\UserProfile',
            'App\User',
            'id',
            'user_id',
            'user_id',
            'id'
            );
    }

}
