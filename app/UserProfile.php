<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';
    protected $primaryKey = "user_id";

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function department()
    {
        return $this->hasOne('App\Department');
    }
}
