<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userprofile extends Model
{
    public $timestamps = false;

    protected $fillable = [
       'bukrs','department_id','position_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function company()
    {
        return $this->hasOne('App\company','bukrs','bukrs');
    }

    public function department()
    {
        return $this->hasOne(department::class,'id','department_id');
    }

    public function position()
    {
        return $this->hasOne(department::class,'id','position_id');
    }
}
