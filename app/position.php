<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class position extends Model
{
    public function userprofile()
    {
        return $this->belongsTo(UserProfile::class);
    }
}
